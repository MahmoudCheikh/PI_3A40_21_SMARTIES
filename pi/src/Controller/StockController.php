<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Stock;
use App\Form\CommandeFrontType;
use App\Form\ProduitType;
use App\Form\StockType;
use App\Repository\ProduitRepository;
use App\Repository\QrCodeRepository;
use App\Repository\StockRepository;
use App\Repository\UsersRepository;
use App\Repository\VeloRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
/**
 * @Route("/stock")
 */
class StockController extends Controller
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct( EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/", name="stock_index", methods={"GET"})
     */
    public function index(StockRepository $stockRepository): Response
    {
        $stock = $stockRepository->findAll();
        return $this->render('stock/index.html.twig',[
            'stocks' => $stock,
        ]);
    }
    private function getData(): array
    {
        /**
         * @var $stock Stock[]
         */
        $list = [];
        $stock = $this->entityManager->getRepository(Stock::class)->findOneBy($list);
        //$stock = $stockRepository->findAll();
        foreach ($stock as $stocks) {
            $list[] = [
                $stock->getId(),
                $stock->getLibelle(),
                $stock->getPrix(),
                $stock->getQuantite(),
                $stock->getDisponibilite(),
                $stock->getIdProduit()
            ];
        }
        return $list;
    }
    /**
     * @Route("/csv", name="excel", methods={"GET"})
     */
    public function excel(StockRepository $stockRepository): Response
    {
        $stock = $stockRepository->findAll(['prix' => $stockRepository ]);
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet()->setAutoFilter($spreadsheet->getActiveSheet()->calculateWorksheetDimension());

        $sheet->setTitle('Stock');

        $sheet->getCell('A1')->setValue('libelle');
        $sheet->getCell('B1')->setValue('prix');
        $sheet->getCell('C1')->setValue('diponibilite');
        $sheet->getCell('D1')->setValue('produit');



        // Increase row cursor after header write
       $sheet->fromArray($stock,null, 'A2', true);
      // $sheet->fromArray(,null, 'B2', true);

        $writer = new Xlsx($spreadsheet);

        // Create a Temporary file in the system
        $fileName = 'Stock.xlsx';

        $temp_file = tempnam(sys_get_temp_dir(), $fileName);

        // Create the excel file in the tmp directory of the system
        $writer->save($temp_file);
        $sheet = $this->renderView('/stock/index.html.twig',[
            'stocks' => $stock,
        ]);


        return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
    }

    /**
     * @Route("/new", name="stock_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $stock = new Stock();
        $form = $this->createForm(StockType::class, $stock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($stock);
            $entityManager->flush();

            return $this->redirectToRoute('stock_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('stock/new.html.twig', [
            'stock' => $stock,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="stock_show", methods={"GET"})
     */
    public function show(Stock $stock): Response
    {
        return $this->render('stock/show.html.twig', [
            'stock' => $stock,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="stock_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Stock $stock, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StockType::class, $stock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('stock_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('stock/edit.html.twig', [
            'stock' => $stock,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="stock_delete", methods={"POST"})
     */
    public function delete(Request $request, Stock $stock, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$stock->getId(), $request->request->get('_token'))) {
            $entityManager->remove($stock);
            $entityManager->flush();
        }

        return $this->redirectToRoute('stock_index', [], Response::HTTP_SEE_OTHER);
    }

 /*   /**
     * @Route("/stockmoins/{id}", name="stockmoins" , methods={"GET","POST"})
     */
   /* public function stockmoins(Request $request, EntityManagerInterface $entityManager, UsersRepository $usersRepository , ProduitRepository $ProduitRepository,StockRepository $stockRepository ,$id,ProduitType $produitType  ): Response
    {
        $produit=$ProduitRepository->find($id);
        $Stock = $stockRepository->findAll();
        $qrCode = null;

        // $form =$produitType;
        //$data = $form->getImage();
        $qrCode = $codeRepository->qrcode($produit);

        $Commande = new Commande();
        $Stock  = new Stock();

        $form = $this->createForm(CommandeFrontType::class,$Commande);
        $from = $this->createForm(StockType::class, $Stock);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $usersRepository->find($this->getuser()->getid());
            $Commande->setIdUser($user);
            $Commande->setIdProduit($produit);
            $entityManager->persist($Commande);

            //STOCK CONTROLE
            //$stock = $stockRepository->findAll();
           //
            $Stock->setQuantite($Stock->getQuantite()-getnbProduits);
            //$event->setNbPlaces($event->getNbPlaces()-1);
            $entityManager->persist($Stock);

            $entityManager->flush();


            return $this->redirectToRoute('commandefront', [], Response::HTTP_SEE_OTHER);
        }


        return $this->render('/produit/ExploreProduit.html.twig', [
            'produit'=> $produit,

            'commande' => $Commande,

            'form' => $form->createView(),
        ]);
    }*/
}
