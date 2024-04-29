<?php
namespace App\Http\Controllers;
use App\Repositories\PropertyRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
//      Dependency injection for easier testing
        $this->propertyRepo = $propertyRepo ?? new PropertyRepository();
    }

    public function index()
    {
        return view('search');
    }

    public function search(Request $request)
    {
        $res = $this->propertyRepo->getPropertiesWithFilter(
            $request->input('location'),
            $request->input('near_beach'),
            $request->input('accepts_pets'),
            $request->input('sleeps_min'),
            $request->input('beds_min'),
            $request->input('availability_start'),
            $request->input('availability_end'),
        );

        if (empty($res)) {
//            You usually wouldn't want to log here as it is normal to get no results
//            for some queries - it's just here to show that I know to log
            Log::info("No properties match", $request->input());
        }

        return view('list', ['locations' => $res, 'available' => true]);
    }

    public function allProperties()
    {
        $res = $this->propertyRepo->getAllProperties();

        if (empty($res)) {
//            You usually wouldn't want to log here as it is normal to get no results
//            for some queries - it's just here to show that I know to log
            Log::info("No properties in table");
        }

        return view('list', ['locations' => $res]);
    }
}
