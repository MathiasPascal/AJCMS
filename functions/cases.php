<?php
class CaseController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllCases() {
        $stmt = $this->pdo->query("SELECT * FROM cases");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCaseById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM cases WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getVerdicts() {
        $stmt = $this->pdo->query("SELECT * FROM verdicts");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPunishments() {
        $stmt = $this->pdo->query("SELECT * FROM punishments");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function assignVerdict($case_id, $verdict_id) {
        $stmt = $this->pdo->prepare("UPDATE cases SET verdict_id = ? WHERE id = ?");
        return $stmt->execute([$verdict_id, $case_id]);
    }

    public function assignPunishment($case_id, $punishment_id) {
        $stmt = $this->pdo->prepare("UPDATE cases SET punishment_id = ? WHERE id = ?");
        return $stmt->execute([$punishment_id, $case_id]);
    }
}
?>
