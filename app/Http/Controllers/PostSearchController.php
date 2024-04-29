<?php
namespace App\Http\Controllers;
use App\Repositories\PropertyRepository;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

//use PropertyRepository;

class PostSearchController extends Controller
{
    private PropertyRepository $propertyRepo;

    /**
     * @param PropertyRepository|null $propertyRepo
     */
    public function __construct(
        ?PropertyRepository $propertyRepo
    ) {
//      Dependency injection to enable easier testing
        $this->propertyRepo = $propertyRepo ?? new PropertyRepository();
    }

    public function index()
    {
        return view('search');
    }

    public function search(Request $request)
    {
        $formData = $this->handleFormData($request);

        $res = $this->propertyRepo->getPropertiesWithFilter(
            $formData['location'] ?? null,
            $formData['near_beach'] ?? null,
            $formData['accepts_pets'] ?? null,
            intval($formData['sleeps_min']) ?? null,
            intval($formData['beds_min']) ?? null,
            $formData['availability_start'] ?? null,
            $formData['availability_end'] ?? null,
        );

        if (empty($res)) {
//            You usually wouldn't want to log here as it is normal to get no results
//            for some queries - it's just here to show that I know to log
            Log::info("No properties match", $request->input());
        }

        $res = collect($res);

        $page = Paginator::resolveCurrentPage();
        $pages = new LengthAwarePaginator($res->forPage($page, 2), $res->count(), 2, $page, ['path' => Paginator::resolveCurrentPath()]);

        return view('list',
            ['source' => 'search',
                'locations' => $pages->items(),
                'available' => true,
                'pages' => range(1, $pages->lastPage())]);
    }

    public function allProperties()
    {
        $res = $this->propertyRepo->getAllProperties();

        if (empty($res)) {
//            You usually wouldn't want to log here as it is normal to get no results
//            for some queries - it's just here to show that I know to log
            Log::info("No properties in table");
        }

        $res = collect($res);

        $page = Paginator::resolveCurrentPage();
        $pages = new LengthAwarePaginator($res->forPage($page, 2),
            $res->count(),
            2,
            $page,
            ['path' => Paginator::resolveCurrentPath()]);

        return view('list',
            ['source' => 'all', 'locations' => $pages->items(), 'pages' => range(1, $pages->lastPage())]
        );
    }

    /**
     * @param Request $request
     * @return Closure|mixed|object|null
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function handleFormData(Request $request): mixed
    {
        $formData = [];
        //        Save form data
        if ($request->method() === 'POST') {
            session(['formData' => $request->input()]);
            $formData = $request->input();
        } elseif ($request->method() === 'GET') {
            $formData = session()->get('formData');
        }
        return $formData;
    }
}
