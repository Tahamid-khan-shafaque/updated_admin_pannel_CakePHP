<?php
declare(strict_types=1);

namespace App\Controller;
use Mpdf\Mpdf;
use Dompdf\Dompdf;
use TCPDF;
use Cake\Controller\Component\PaginatorComponent;
use Cake\ORM\Query;
use Cake\Controller\Controller;
use Cake\Http\Response;
use Cake\ORM\TableRegistry;

/**
 * Persons Controller
 *
 * @property \App\Model\Table\PersonsTable $Persons
 * @method \App\Model\Entity\Person[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PersonsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Persons->find();
    
        // Check if a search query is provided
        $search = $this->request->getQuery('search');
        if (!empty($search)) {
            $query->where([
                'OR' => [
                    'name LIKE' => '%' . $search . '%',
                    'email LIKE' => '%' . $search . '%',
                    // Add other fields you want to search here
                ]
            ]);
        }
    
        $this->paginate = [
            'limit' => 5, // Number of records per page
        ];
    
        $persons = $this->paginate($query);
    
        $this->set(compact('persons'));
    }
    /**
     * View method
     *
     * @param string|null $id Person id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $person = $this->Persons->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('person'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $person = $this->Persons->newEmptyEntity();
        if ($this->request->is('post')) {
            $person = $this->Persons->patchEntity($person, $this->request->getData());
       //upload image

       if(!$person->getErrors){
        $image = $this->request->getData('image_file');

        $name  = $image->getClientFilename();

        if( !is_dir(WWW_ROOT.'img'.DS.'user-img') )
        mkdir(WWW_ROOT.'img'.DS.'user-img',0775);
        
        $targetPath = WWW_ROOT.'img'.DS.'user-img'.DS.$name;

        if($name)
        $image->moveTo($targetPath);
        
        $person->image = 'user-img/'.$name;
    }

            if ($this->Persons->save($person)) {
                $this->Flash->success(__('The person has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The person could not be saved. Please, try again.'));
        }
        $this->set(compact('person'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Person id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $person = $this->Persons->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $person = $this->Persons->patchEntity($person, $this->request->getData());
            if ($this->Persons->save($person)) {
                $this->Flash->success(__('The person has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The person could not be saved. Please, try again.'));
        }
        $this->set(compact('person'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Person id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function download($id = null)
{
    $person = $this->Persons->get($id);

    require_once(ROOT . DS . 'vendor' . DS . 'tecnickcom' . DS . 'tcpdf' . DS . 'tcpdf.php');

    $pdf = new TCPDF();
    $pdf->AddPage();
    $pdf->SetFont('times', '', 12);

    
    $imageX = ($pdf->getPageWidth() - 40) / 2; 
    $imageY = 50; 


    if (!empty($person->image)) {
        $imagePath = WWW_ROOT . 'img' . DS . $person->image;
        $pdf->Image($imagePath, $imageX, $imageY, 40, 0, '', '', '', false, 300, '', false, false, 0);
    }


    $tableX = 15;
    $tableY = $imageY + 30; 


    $tableData = [
        ['Attribute', 'Value'],
        ['ID', $person->id],
        ['Name', $person->name],
        ['Email', $person->email],
        ['Phone', $person->phone],
        ['Department', $person->department],
        ['Blood Group', $person->bloodgroup],
        ['Gender', $person->gender],
        ['Skillset', $person->skillset],
      
    ];

    $tableWidths = [50, 140]; 

  
    $tableHeight = count($tableData) * 10;

   
    $tableY = ($pdf->getPageHeight() - $tableHeight) / 2;


    $pdf->SetFont('times', 'B', 16); 
    $pdf->SetTextColor(0, 51, 102); 
    $pdf->SetXY($tableX, 15); 
    $pdf->Cell(0, 10, 'USER INFORMATION', 0, 1, 'C');

    
    $pdf->SetFont('times', '', 12);
    $pdf->SetTextColor(0, 0, 0); 

   
    $pdf->SetFillColor(0, 51, 102); 
    $pdf->SetTextColor(255, 255, 255); 


    $isHeader = true; 
    foreach ($tableData as $row) {
        $pdf->SetXY($tableX, $tableY);
   
        if (in_array($row[0], ['ID', 'Email', 'Department', 'Gender'])) {
            $pdf->SetFillColor(0, 128, 0);
        } else {
            $pdf->SetFillColor(0, 51, 102); 
        }
        $pdf->Cell($tableWidths[0], 10, $row[0], 1, 0, 'L', 1); 
        $pdf->Cell($tableWidths[1], 10, $row[1], 1, 1, 'L', 1); 
        $tableY += 10; 
        $isHeader = !$isHeader; 
    }

    $pdfContent = $pdf->Output('', 'S');

    $this->response = $this->response->withType('application/pdf')
        ->withHeader('Content-Disposition', 'attachment;filename=user_info.pdf')
        ->withHeader('Content-Length', strlen($pdfContent))
        ->withHeader('Cache-Control', 'no-store, no-cache, must-revalidate')
        ->withHeader('Pragma', 'no-cache')
        ->withHeader('Expires', '0');

    $this->response = $this->response->withStringBody($pdfContent);

    return $this->response;
}

    //login register part
    
    
    
}
