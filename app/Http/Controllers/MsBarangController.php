<?php

namespace App\Http\Controllers;

use App\Models\MsBarang;
use App\Http\Requests\UpdateMsBarangRequest;
use App\Http\Requests\StoreMsBarangRequest;
use App\Policies\MsBarangPolicy;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MsBarangController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(MsBarang::class);
    }

    protected function buildQuery()
    {
      return MsBarang::query()
        ->select((new MsBarang)->getDisplayableFields());
    }

    protected function buildDatatable($query)
    {
      return datatables($query);
        // ->addColumn("firstCol", function (MsBarang $record) {
        //   return $record->field;
        // })
        // ->addColumn("secondCol", function (MsBarang $record) {
        //   return $record->field;
        // });
    }

    public function json()
    {
      $query = $this->buildQuery()
        ->limit(20);
      return $this->buildDatatable($query)->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        if ($request->ajax()) {
            return $this->buildDatatable($this->buildQuery())
                ->addColumn('actions', function (MsBarang $record) use ($user) {
                    $actions = [
                      $user->can(MsBarangPolicy::POLICY_NAME.".view") ? "<a href='" . route("ms-barang.show", $record->id) . "' class='btn btn-xs btn-primary modal-remote' title='Show'><i class='fas fa-eye'></i></a>" : '', // show
                      $user->can(MsBarangPolicy::POLICY_NAME.".update") ? "<a href='" . route("ms-barang.edit", $record->id) . "' class='btn btn-xs btn-warning modal-remote' title='Edit'><i class='fas fa-pencil-alt'></i></a>" : '', // edit
                      $user->can(MsBarangPolicy::POLICY_NAME.".delete") ? "<a href='" . route("ms-barang.destroy", $record->id) . "' class='btn btn-xs btn-danger btn-delete' title='Delete'><i class='fas fa-trash'></i></a>" : '', // delete
                    ];

                    return '<div class="btn-group">' . implode('', $actions) . '</div>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        } else {
            return view('ms-barang.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      $view = view('ms-barang.create', ['record' => null]);
      if ($request->ajax()) {
        return response()->json([
          'title' => "Tambah Master Barang",
          'content' => $view->render(),
          'footer' => '<button type="submit" class="btn btn-primary">Simpan</button>',
        ]);
      } else {
        return $view;
      }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreMsBarangRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMsBarangRequest $request)
    {
        MsBarang::create($request->validated() + ['created_by' => auth()->id()]);
        if ($request->ajax()) {
            return [
                'code' => 200,
                'message' => 'Success',
            ];
        } else {
            return redirect()->route("ms-barang.index");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  MsBarang  $msBarang
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, MsBarang $msBarang)
    {
      $view = view('ms-barang.show', ['record' => $msBarang]);
      if ($request->ajax()) {
        return response()->json([
          'title' => "Lihat Master Barang",
          'content' => $view->render(),
        ]);
      } else {
        return $view;
      }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  MsBarang  $msBarang
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, MsBarang $msBarang)
    {
      $view = view('ms-barang.edit', ['record' => $msBarang]);
      if ($request->ajax()) {
        return response()->json([
          'title' => "Edit Master Barang",
          'content' => $view->render(),
          'footer' => '<button type="submit" class="btn btn-primary">Simpan</button>',
        ]);
      } else {
        return $view;
      }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateMsBarangRequest  $request
     * @param  MsBarang  $msBarang
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMsBarangRequest $request, MsBarang $msBarang)
    {
        $msBarang->update($request->validated());
        if ($request->ajax()) {
            return [
                'code' => 200,
                'message' => 'Success',
            ];
        } else {
            return redirect()->route("ms-barang.index");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  MsBarang  $msBarang
     * @return \Illuminate\Http\Response
     */
    public function destroy(MsBarang $msBarang)
    {
        $msBarang->delete();
        return [
            'code' => 200,
            'message' => 'Success',
        ];
    }
}
