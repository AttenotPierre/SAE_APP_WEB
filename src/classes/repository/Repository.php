<?php

declare(strict_types=1);
namespace iutnc\SAE_APP_WEB\repository;
use classes\video\Catalogue;
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
        $query = "SELECT * FROM Series";
        $stmt = $this->pdo->query($query);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $catalogue = new Catalogue();
        foreach ($result as $row) {
            $series = new \classes\video\Series(
                (int)$row['id'],
                $row['title'],
                $row['description'],
                $row['img'],
                (int)$row['annee'],
                $row['dateAjout'],
                $row['theme'],
                $row['public_cible']
            );
            $catalogue->addSeries($series);
        }
        return $catalogue;
    }

}
