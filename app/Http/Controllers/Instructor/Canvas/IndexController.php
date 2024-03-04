<?php
namespace App\Http\Controllers\Instructor\Canvas;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\InstructorDomain\Canvas\Presenter\Breadcrumb\Instructor\IndexBreadcrumb;
use App\Src\InstructorDomain\Canvas\Repository\CanvasRepository;


class IndexController extends Controller
{
    use Breadcrumable;
    
    private CanvasRepository $canvasRepository;

    public function __construct (CanvasRepository $canvasRepository){

        $this->canvasRepository = $canvasRepository;
        
    }

    public function __invoke()
    {

        $instructor = user();
        
        $breadcrumb = new IndexBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);
        
        $canvas = $this->canvasRepository->keys($instructor);
        $launchUrl = config('linguameeting.canvas.default.url'); // falta saber cuál es la url definitiva
        $showKeys = false;
        
        if(!empty($canvas)){
            $showKeys = true;
        }
        
        view()->share([
            'canvas' => $canvas,
            'showKeys' => $showKeys,
            'launchUrl' => $launchUrl,
        ]);


        return view('instructor.canvas.index');
    }
}
