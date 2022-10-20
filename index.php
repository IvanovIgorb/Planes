<?php
    abstract class Plane{
        public $name;
        public $speed;
        private $status;

        public function __construct(string $name="", string $speed=""){
            $this->name = $name;
            $this->speed = $speed;
        }

        public function takeOff(){
            $this->status = "В воздухе";
            echo "Полетели! Ваш самолет - ".$this->type." ".$this->name.". Максимальная скорость - ". $this->speed. "...<br/>";
        }

        public function land(){
            $this->status = "На земле";
            echo "Приземлились! Ваш самолет - ".$this->type." ".$this->name.". Максимальная скорость - ". $this->speed. "...<br/>";
        }

        public function GetStatus(){
            echo "Статус самолета ". $this->type." ". $this->name. " - ". $this->status ."...<br/>";
        }
    }
    
    class MIG extends Plane{
        protected $type = "MIG";
        protected $airport;

        public function RequestLanding(){
            //Композиция 
            $this->airport = new Airport();  // Создает объект другого класса
            $this->airport->TakePlane(); // Использует объект другого класса
        }

        public function PlaneTakeOffConfirm(Airport $airport){
            // Агрегация 
            $this->airport = $airport;
            $this->airport->PlaneTakeOff(); // Использует объект другого класса
        }
        public function CheckPlaneOnMaintenance(Airport $airport){
            // Ассоциация
            $airport->PlaneOnMaintenance();
        }
    }

    class TU154 extends Plane{
        protected $type = "TU154";
        protected $airport;

        public function RequestToTakeOff(){
            //Композиция 
            $this->airport = new Airport();  // Создает объект другого класса
            $this->airport->PlaneReadyToTakeOff(); // Использует объект другого класса
        }

        public function PlaneTakeOffConfirm(Airport $airport){
            //Ассоциация
            $airport->PlaneTakeOff(); // Использует объект другого класса
        }

        public function RequestAtacking(Airport $airport){
            //Агрегация
            $this->airport = $airport;
            $this->airport->PlaneAttakingaApproving(); // Использует объект другого класса
        }

        public function Attack(){
            echo "Самолет ". $this->name ." Атакует...<br/>";
        }

    }

    class Airport{
        protected $plane;

        public function TakePlane(){
            echo "Аэропорт готов принять самолет...<br/>";
        }

        function PlaneTakeOff(){
            echo "Самолет улетел и освободил место...<br/>";
        }

        function PlaneInPark(){
            echo "Самолет ушел на стоянку...<br/>";
        }

        function PlaneReadyToTakeOff(){
            echo "Самолет готов взлетать...<br/>";
        }
        
        function PlaneOnMaintenance(){
            echo "Самолет на техобслуживании...<br/>";
        }

        function PlaneAttakingaApproving(){
            echo "Аэропорт дает разрешение на атаку...<br/>";
        }
    }

    $airport = new Airport(); // Создает объект другого класса

    $migPlane = new MIG("nice","over900");
    $migPlane->CheckPlaneOnMaintenance($airport); // Использует объект другого класса
    $migPlane->takeOff();
    $migPlane->PlaneTakeOffConfirm($airport); // Использует объект другого класса
    $migPlane->GetStatus();
    $migPlane->RequestLanding();
    $migPlane->land();

    $tuPlane = new TU154("bruh","very very fast"); 
    $tuPlane->RequestToTakeOff();
    $tuPlane->takeOff();
    $tuPlane->PlaneTakeOffConfirm($airport);
    $tuPlane->RequestAtacking($airport); // Использует объект другого класса
    $tuPlane->Attack();
?>
