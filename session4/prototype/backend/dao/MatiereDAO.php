<?php
require_once __DIR__ . '/../class/Matiere.php';

class MatiereDAO
{
    private string $dataFile;

    public function __construct(?string $dataFile = null)
    {
        $this->dataFile = $dataFile ?? __DIR__ . '/../data/gestionMatiere.json';
    }

    /**
     * @return Matiere[]
     */
    public function findAll(): array
    {
        return $this->withLockedDataFile(function ($handle): array {
            $matieres = [];

            foreach ($this->readRecords($handle) as $index => $record) {
                if (!is_array($record)) {
                    throw new UnexpectedValueException('Invalid subject record ' . ($index + 1));
                }

                $nom = $record['nom'] ?? $record['name'] ?? null;
                $description = $record['description'] ?? null;
                if (!is_int($record['id'] ?? null) || !is_string($nom) || !is_string($description)) {
                    throw new UnexpectedValueException('Invalid subject record ' . ($index + 1));
                }

                $matieres[] = new Matiere($record['id'], $nom, $description);
            }

            return $matieres;
        });
    }

    public function save(Matiere $matiere): Matiere
    {
        return $this->withLockedDataFile(function ($handle) use ($matiere): Matiere {
            $records = $this->readRecords($handle);
            $nextId = 1;

            foreach ($records as $record) {
                if (!is_array($record) || !is_int($record['id'] ?? null)) {
                    throw new UnexpectedValueException('Invalid subject data file');
                }
                $nextId = max($nextId, $record['id'] + 1);
            }

            $savedMatiere = new Matiere($nextId, $matiere->getNom(), $matiere->getDescription());
            $records[] = [
                'id' => $savedMatiere->getId(),
                'nom' => $savedMatiere->getNom(),
                'description' => $savedMatiere->getDescription(),
            ];

            try {
                $json = json_encode($records, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
            } catch (JsonException $exception) {
                throw new RuntimeException('Unable to encode subject data', 0, $exception);
            }

            rewind($handle);
            if (!ftruncate($handle, 0) || fwrite($handle, $json . PHP_EOL) === false || !fflush($handle)) {
                throw new RuntimeException('Unable to save subject data');
            }

            return $savedMatiere;
        });
    }

    private function withLockedDataFile(callable $operation): mixed
    {
        $handle = fopen($this->dataFile, 'c+');
        if ($handle === false) {
            throw new RuntimeException('Unable to open subject data file');
        }

        try {
            if (!flock($handle, LOCK_EX)) {
                throw new RuntimeException('Unable to lock subject data file');
            }

            return $operation($handle);
        } finally {
            flock($handle, LOCK_UN);
            fclose($handle);
        }
    }

    private function readRecords($handle): array
    {
        rewind($handle);
        $contents = stream_get_contents($handle);
        if ($contents === false) {
            throw new RuntimeException('Unable to read subject data file');
        }
        if (trim($contents) === '') {
            return [];
        }

        try {
            $records = json_decode($contents, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            throw new UnexpectedValueException('Subject data file contains invalid JSON', 0, $exception);
        }

        if (!is_array($records)) {
            throw new UnexpectedValueException('Subject data file must contain a JSON array');
        }

        return $records;
    }
}
