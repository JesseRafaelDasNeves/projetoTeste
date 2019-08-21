<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Marca;

class MarcaController extends Controller {

    /** @var Marca */
    protected $Marca;

    const FORM_INCLUIR = 10,
          FORM_ALTERAR = 11,
          FORM_EXCLUIR = 12;

    public function __construct() {
        $this->middleware('auth');
        $this->Marca = new Marca();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        /* @var $marcas \Illuminate\Pagination\LengthAwarePaginator */
        $marcas      = $this->Marca->orderBy('codigo')->paginate(7);
        $currentPage = $marcas->currentPage();

        $success     = session('success');

        return view('marca-consulta', compact('marcas', 'currentPage', 'success'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $marca       = $this->Marca;
        $nomeForm    = "Incluir Marca";
        $currentPage = request()->get('currentPage', 1);

        $marca->setAttribute('codigo', old('codigo'));
        $marca->setAttribute('nome'  , old('nome'));

        return $this->createViewManutencao($marca, self::FORM_INCLUIR, $nomeForm, false, $currentPage);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request, $this->Marca->getRules(), $this->Marca->getMessageValidate());
        $bInseriu = $this->Marca->create($request->all());

        if($bInseriu) {
            $currentPage = request()->get('currentPage', 1);
            $success     = 'Marca incluída com sucesso.';
            return redirect()->route('marcas.index', ['page' => $currentPage])->with('success', $success);
        }

        return redirect()->route('marcas.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $marca       = $this->Marca->find($id);
        $nomeForm    = "Excluir Marca [Id: $id]";
        $currentPage = request()->get('currentPage', 1);

        return $this->createViewManutencao($marca, self::FORM_EXCLUIR, $nomeForm, true, $currentPage);
    }

    private function createViewManutencao(Marca $marca, int $tipoForm, string $nomeFormulario, bool $bReadonly = false, $currentPage = 1) {
        $readonly = $bReadonly ? 'readonly' : '';
        return view('marca-manutencao', compact('marca', 'tipoForm', 'readonly', 'nomeFormulario', 'currentPage'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        /* @var $marca Marca */
        $marca       = $this->Marca->find($id);
        $nomeForm    = "Alterar Marca [Id: $id]";
        $currentPage = request()->get('currentPage', 1);

        if(count(old()) > 0) {
            $marca->setAttribute('codigo', old('codigo'));
            $marca->setAttribute('nome'  , old('nome'));
        }

        return $this->createViewManutencao($marca, self::FORM_ALTERAR, $nomeForm, false, $currentPage);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        /* @var $marca Marca */
        $marca    = $this->Marca->find($id);
        $this->validate($request, $marca->getRules(), $marca->getMessageValidate());
        $bAlterou = $marca->update($request->all());

        if($bAlterou) {
            $currentPage = $request->get('currentPage', 1);
            $success     = 'Marca alterada com sucesso.';
            return redirect()->route('marcas.index', ['page' => $currentPage])->with('success', $success);
        }

        return redirect()->route('marcas.create');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $bdelete = $this->Marca->destroy($id);

        if($bdelete) {
            $currentPage = request()->get('currentPage', 1);
            $success     = 'Marca excluída com sucesso.';
            return redirect()->route('marcas.index', ['page' => $currentPage])->with('success', $success);
        }

        return redirect()->route('marcas.destroy');
    }
}
