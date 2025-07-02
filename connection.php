<?php

class Connect extends PDO
{
    const HOST = "localhost";
    const DB = "gestioncommandes";
    const USER = "root";
    const PSW = "bonucci77";

    public function __construct()
    {
        try {
            parent::__construct(
                "mysql:host=" . self::HOST . ";dbname=" . self::DB,
                self::USER,
                self::PSW
            );
            // إعدادات إضافية (اختياري)
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            // echo "WElcome TO BDD";
        } catch (PDOException $e) {
            die("خطأ في الاتصال بقاعدة البيانات: " . $e->getMessage());
        }
    }
}
