<?php

declare(strict_types=1);
namespace iutnc\SAE_APP_WEB\repository;
use iutnc\SAE_APP_WEB\video\Catalogue;
use iutnc\SAE_APP_WEB\video\Episode;
use iutnc\SAE_APP_WEB\video\Series;
use PDO;

class Repository{
    private PDO $pdo;
    private static ?Repository $instance = null;
    private static array $config;

    private function __construct(array $conf) {
        $this->pdo = new PDO(
            $conf['dsn'], 
            $conf['user'], 
            $conf['pass'],
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }

    public static function getInstance(): Repository {
        if (self::$instance === null) {
            if (empty(self::$config)) {
                throw new \Exception("Config not set");
            }
            self::$instance = new Repository(self::$config);
        }
        return self::$instance;
    }

    public static function setConfig(string $file): void {
        $conf = parse_ini_file($file);
        if ($conf === false) {
            throw new \Exception("Error reading configuration file");
        }
        self::$config = [
            'dsn' => "{$conf['driver']}:host={$conf['host']};dbname={$conf['database']};charset=utf8mb4",
            'user' => $conf['username'],
            'pass' => $conf['password']
        ];
    }

    public function addUser(string $email, string $pseudo, string $hash): void {
        $query = "INSERT INTO User (email, pseudo,  passwd) VALUES (:email, :pseudo, :passwd)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['email' => $email, 'pseudo' => $pseudo, 'passwd' => $hash]);
    }

    public function userExists(string $email): bool {
        $query = "SELECT COUNT(*) as count FROM User WHERE email = :email";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return ($result['count'] > 0);
    }

    public function getHashUser(String $email): ?String {
        $query = "SELECT passwd FROM User WHERE email = :email";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (isset($result['passwd'])) ? $result['passwd']:null;

    }

    public function getCatalogue(): Catalogue {
        $query = "SELECT * FROM serie";
        $stmt = $this->pdo->query($query);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $catalogue = new Catalogue();
        foreach ($result as $row) {
            $series = new Series(
                (int)$row['id'],
                $row['titre'],
                $row['descriptif'],
                $row['img'],
                (int)$row['annee'],
                $row['date_ajout'],
                $row['theme']?? "Non défini",
                $row['public_cible'] ?? "Non défini"
            );
            $catalogue->addSeries($series);
        }
        return $catalogue;
    }

    public function getUserIdByEmail(string $email): ?int {
        $query = "SELECT id FROM User WHERE email = :email";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? (int)$result['id'] : null;
    }


    public function getSeriePref(int $id_user): Catalogue {
        $query = "SELECT * FROM serie where id_user = :id_user";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id_user' => $id_user]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $catalogue = new Catalogue();
        foreach ($result as $row) {
            $series = new Series(
                (int)$row['id'],
                $row['titre'],
                $row['descriptif'],
                $row['img'],
                (int)$row['annee'],
                $row['date_ajout'],
                $row['theme']?? "Non défini",
                $row['public_cible'] ?? "Non défini"
            );
            $catalogue->addSeries($series);
        }
        return $catalogue;
    }

    public function getSerie(int $id_serie): Series {
        $query = "SELECT * FROM serie WHERE id = :id_serie";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id_serie' => $id_serie]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Series(
                (int)$row['id'],
                $row['titre'],
                $row['descriptif'],
                $row['img'],
                (int)$row['annee'],
                $row['date_ajout'],
                $row['theme']?? "Non défini",
                $row['public_cible'] ?? "Non défini"
            );
        }
        throw new \Exception("La série n'existe pas");
    }

    /**
     * @throws \Exception
     */
    public function getEpisodesBySerieId(int $serieId): Series {
        $query = "SELECT * FROM episode WHERE serie_id = :serie_id ORDER BY numero ASC";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['serie_id' => $serieId]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $series = $this->getSerie($serieId);
        foreach ($result as $row) {
            $episode = new Episode(
                (int)$row['id'],
                (int)$row['numero'],
                $row['titre'],
                $row['resume'],
                (int)$row['duree'],
                $row['file'],
                (int)$row['serie_id']
            );
            $series->addEpisode($episode);
        }
        return $series;
    }

    public function getSeriePrefByUserId(int $id_user) : Catalogue {
        $query = "SELECT * from serie inner join user2serie_listepref on serie.id = user2serie_listepref.id_serie where user2serie_listepref.id_user = :id_user";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id_user' => $id_user]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $catalogue = new Catalogue();
        foreach ($result as $row) {
            $series = new Series(
                (int)$row['id'],
                $row['titre'],
                $row['descriptif'],
                $row['img'],
                (int)$row['annee'],
                $row['date_ajout'],
                $row['theme']?? "Non défini",
                $row['public_cible'] ?? "Non défini"
            );
            $catalogue->addSeries($series);
        }
        return $catalogue;
    }

    /**
     * @throws \Exception
     */
    public function getEpisodeById(int $id_episode): Episode {
        $query = "SELECT * FROM episode WHERE id = :id_episode";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id_episode' => $id_episode]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Episode(
                (int)$row['id'],
                (int)$row['numero'],
                $row['titre'],
                $row['resume'],
                (int)$row['duree'],
                $row['file'],
                (int)$row['serie_id']
            );
        }
        throw new \Exception("L'épisode n'existe pas");
    }


}
