<?php
namespace App\Http\Controllers\Instructor\Resources;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\InstructorDomain\Resources\Presenter\Breadcrumb\Instructor\IndexBreadcrumb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class IndexController extends Controller
{
    use Breadcrumable;

    public function __construct (){

    }


    public function __invoke(Request $request)
    {
        $userId = auth()->id();

        if($request->has('language')){
            if($request->language === 'all'){
                $conversations = DB::table('user_language')
                ->join('language', 'user_language.language_id', '=', 'language.id')
                ->join('conversation_guide', 'language.id', '=', 'conversation_guide.language_id')
                ->select('conversation_guide.id', 'conversation_guide.name')
                ->where('user_language.user_id', $userId)
                ->get(); 

            }else{
                $conversations = DB::table('user_language')
                ->join('language', 'user_language.language_id', '=', 'language.id')
                ->join('conversation_guide', 'language.id', '=', 'conversation_guide.language_id')
                ->select('conversation_guide.id', 'conversation_guide.name')
                ->where('user_language.user_id', $userId)
                ->where('language.name', $request->language)
                ->get();
            }
        }else{
            $conversations = DB::table('user_language')
            ->join('language', 'user_language.language_id', '=', 'language.id')
            ->join('conversation_guide', 'language.id', '=', 'conversation_guide.language_id')
            ->select('conversation_guide.id', 'conversation_guide.name')
            ->where('user_language.user_id', $userId)
            ->get();  
        }

        $chapter = DB::table('user_language')
            ->join('language','user_language.language_id','=','language.id')
            ->join('conversation_guide', 'language.id', '=', 'conversation_guide.language_id')
            ->join('conversation_guide_chapter','conversation_guide.id','=','conversation_guide_chapter.conversation_guide_id')
            ->select('conversation_guide_chapter.id', 'conversation_guide_chapter.name','conversation_guide_chapter.conversation_guide_id')
            ->where('user_language.user_id', $userId)
            ->get();

        $languages = DB::table('user_language')
        ->join('language', 'user_language.language_id', '=', 'language.id')
        ->join('conversation_guide', 'language.id', '=', 'conversation_guide.language_id')
        ->join('conversation_guide_chapter', 'conversation_guide.id', '=', 'conversation_guide_chapter.conversation_guide_id')
        ->select('language.id', 'language.name')
        ->where('user_language.user_id', $userId)
        ->distinct()
        ->get();

        $breadcrumb = new IndexBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);


        return view('instructor.resources.index', compact('languages', 'conversations', 'chapter'));
    }
}
