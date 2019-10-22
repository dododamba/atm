<?php

namespace App\Http\Controllers;

use App\FpdfRemix;
use App\Models\Contribuables;
use App\ModelsEmployes;
use App\User;
use Illuminate\Http\Request;
use App\Models\Actions;
use App\Models\Encaissements;
class PageController extends Controller
{

    protected $tampon_statistiques ;
    protected $reports = ["stats_detaillees","stats_charts"] ;

    public function historiques()
    {
      $listeActions = Actions::orderBy("created_at","DESC")->get();
      return view('historiques.index',compact("listeActions"));
    }

    public function contribualbes()
    {
       $collection = \App\Contribuable::paginate(10);
      return view('contribualbes.index',compact('collection'));
    }

    public function createContribualbes()
    {
        $nationalites = \App\Nationalite::all();
        $categories = \App\CategorieContribuable::all();
      return view('contribualbes.create',compact('categories','nationalites'));
    }

    public function categoriecontribuables()
    {
      return view('categoriecontribuables.index');
    }

    public function taxes()
    {
      return view('taxe.index');
    }

    public function categorietaxe()
    {
      return view('categorietaxe.index');
    }

    public function hotels()
    {
      return view('hotels.index');
    }

    public function commune()
    {
        return view('commune.index');
    }

    public function statistique(Request $request)
    {

        $listerEncaissements = Encaissements::orderBy('simpledateEnc',"DESC");

        if($request->date_debut && $request->date_debut != "" )
            $listerEncaissements->where("simpledateEnc",">=",$request->date_debut);
        if($request->date_fin && $request->date_fin != "")
            $listerEncaissements->where("simpledateEnc","<=",$request->date_fin);
        
        $listerEncaissements = $listerEncaissements->get();
        $this->tampon_statistiques = $listerEncaissements;

        return view('statistique.index' , compact("listerEncaissements"))->with(["data_debut"=>$request->date_debut, "data_fin"=>$request->date_fin]);

    }

    public function print_stats(Request $request){

        $pdf = new FpdfRemix();
        $pdf->AddPage();
        $pdf->setXY(45,30);
        $pdf->SetFont('Arial','B',12);
        $pdf->MultiCell(145,5,"LISTE DES ENCAISSEMENTS",0,"C");

        $pdf->AliasNbPages();
        $this->drawTabHeader($pdf) ;

        $pdf->setXY(15,45);
        $pdf->SetFont('Times','',8);
        $hauteur = 5;
        $order = 1;
        foreach ($this->tampon_statistiques as $key => $value) {
            $this->drawTabLine($pdf,$value,15,45+$hauteur, $order);
            $hauteur += 5;
            $order++;
            if($order % 45 == 0){
                $pdf->AddPage();
                $this->drawTabHeader($pdf);
                $hauteur = 5;
            }
        }

        exit;
    }

    public function typeemploye()
    {
        return view('typeemploye.index');
    }

    public function employe()
    {
        return view('employe.index');
    }

    public function stats_detaillees(){

    }

    public function stats_charts(){

    }



    private function displayData($pdf, $data){
        $pdf->SetTextColor(100 , 100, 100);
        $pdf->SetFont('Arial','',8);

        $pdf->SetXY(LEFT_TOP_X + 12 ,LEFT_TOP_Y+10);
        $pdf->Cell(30,3,$data[0]["libelle"],0,0,'L');

        $pdf->SetXY(LEFT_TOP_X+75,LEFT_TOP_X+20);
        $pdf->Cell(30,3,$data[0]["disponibilite"],0,0,'C');

        $pdf->SetXY(LEFT_TOP_X+145,LEFT_TOP_Y+10);
        $d = new DateTime($data[0]["dateoperation"],new DateTimeZone("Africa/Libreville"));
        $pdf->Cell(10,3,$d->format("d/m/Y"),0,0,'L');

        $pdf->SetXY(LEFT_TOP_X + 142,LEFT_TOP_Y+22);
        $pdf->Cell(38,3,$data[0]['reference'],0,0,'L');

        $pdf->SetXY(LEFT_TOP_X +20,LEFT_TOP_Y+42);
        $pdf->Cell(14,3,$data[0]['matricule_contribuable'],0,0,'L');

        $pdf->SetXY(LEFT_TOP_X +35,LEFT_TOP_Y+49);
        $pdf->MultiCell(50,3,$data[0]['libelleRecipisse'] .' : '. $data[0]['libelleLigne'],0);

        $pdf->SetXY(LEFT_TOP_X +120,LEFT_TOP_Y+42);
        $pdf->MultiCell(40,3,$data[0]['nom_contribuable'],0);

        $decal = 0;

        foreach ($data as $num => $val){
            $pdf->SetXY(LEFT_TOP_X,LEFT_TOP_Y+77+$decal);
            $pdf->Cell(10,3,$num+1,0,0,'C');

            $pdf->SetXY(LEFT_TOP_X+23,LEFT_TOP_Y+77+$decal);
            $pdf->Cell(28,3,$val['imputation'],0,0,'C');

            $pdf->SetXY(LEFT_TOP_X+65,LEFT_TOP_Y+77+$decal);
            $pdf->Cell(34,3,$val['matricule_contribuable'],0,0,'C');

            $pdf->SetXY(LEFT_TOP_X+127,LEFT_TOP_Y+77+$decal);
            $pdf->Cell(40,3,str_pad($val['montant_details'],30,"*",STR_PAD_LEFT),0,0,'R');

            $decal += 6 ;
        }

        $pdf->SetXY(LEFT_TOP_X+127,LEFT_TOP_Y+107);
        $pdf->MultiCell(40,3,str_pad($val['montant'],30,"*",STR_PAD_LEFT),0,'C','');

        $pdf->SetXY(LEFT_TOP_X+67,LEFT_TOP_Y+113);
        $pdf->MultiCell(40,3,$_SESSION["tresor_user"]["name"],0,'C','');
    }

    private function drawTabHeader($pdf)
    {
        //    $pdf->SetFont('Times','',12);
        $pdf->SetFont('Arial','B',9);

        $pdf->setXY(15,45);
        $pdf->MultiCell(10,5,"No",1,"",'');
        $pdf->setXY(25,45);
        $pdf->MultiCell(50,5,"Date/Heure",1,"",'');
        $pdf->setXY(75,45);
        $pdf->MultiCell(35,5,"Partie versante",1,"",'');
        $pdf->setXY(110,45);
        $pdf->MultiCell(15,5,"Montant",1,"",'');
        $pdf->setXY(125,45);
        $pdf->MultiCell(40,5,"Caissier(e)",1,"C",'');
        $pdf->setXY(165,45);
        $pdf->MultiCell(30,5,"Montant",1,"",'');
        //$pdf->MultiCell(183,5,"",1,"",'');

    }

    private function drawTabLine($pdf,$arrayData, $X, $Y, $order){
        $pdf->SetFont('Arial','',9);
        $pdf->setXY($X,$Y);
        $pdf->MultiCell(10,5,$order,1,"",'');
        $pdf->setXY($X +10,$Y);
        $timeZone = 'Africa/libreville';  // +1 hours
        date_default_timezone_set($timeZone);
        $dateTime = new DateTime($arrayData->created_at);
        $pdf->MultiCell(50,5,$dateTime->format('Y-m-d H:i:s'),1,"",'');

        $pdf->setXY($X+60,$Y);
        $objVersant = ($arrayData->idEmploye) ? ModelsEmployes::find($arrayData->idEmploye) : Contribuables::find($arrayData->idContribuable);
        $nomcomplet = ($objVersant->nomEmp) ? $objVersant->nomEmp." ".$objVersant->prenomEmp : $objVersant->nom." ".$objVersant->prenoms;

        $pdf->MultiCell(35,5,$nomcomplet,1,"",'');

        $pdf->setXY($X+95,$Y);
        $pdf->MultiCell(15,5,$arrayData->montanEnc,1,"",'');

        $pdf->setXY($X+110,$Y);
        $objUser =  User::find($arrayData->idUser);
        $nom = $objUser->nom.' '.$objUser->prenom;
        $pdf->MultiCell(40,5,$nom,1,"C",'');

        $pdf->setXY($X+150,$Y);
        $pdf->MultiCell(30,5,' ',1,"",'');
    }


    private function random_color_part() {
        return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
    }

    private function random_color() {
        return array($this->random_color_part(), $this->random_color_part(),$this->random_color_part());
    }


    private function drawStatsFirstPage($pdf, $data)
    {
        $pdf->AddPage();
        $pdf->setXY(45,30);
        $pdf->SetFont('Arial','B',12);
        $pdf->MultiCell(145,5,"GRAPHIQUE DES TRANSACTIONS PAR INSTITUTION",0,"C");

        //Pie chart

        $pdf->Ln(8);

        $pdf->SetFont('Arial', '', 10);
        $valX = $pdf->GetX();
        $valY = $pdf->GetY();
        foreach ($data as $key => $value) {
            $pdf->Cell(30, 5, $key);
            $pdf->Cell(15, 5, $value." XAF", 0, 0, 'R');
            $pdf->Ln();
        }
        $pdf->Ln(8);

        $pdf->SetXY(55, $valY);
        $colors = array();
        $nb = count($data);

        for($i = 0; $i < $nb; $i++) {
            $col = array();
            for($j = 0; $j < 3; $j++) {
                $gray = rand(0,255);
                array_push($col,$gray);
            }
            array_push($colors,$col);
        }

        $pdf->PieChart(180, 100, $data, '%l (%p)', $colors);
        $pdf->SetXY($valX, $valY + 40);
    }



}
