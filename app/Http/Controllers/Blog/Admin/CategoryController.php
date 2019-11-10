<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Requests\BlogCategoryCreateRequest;
use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Models\BlogCategory;
use App\Repositories\BlogCategoryRepository;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @var BlogCategoryRepository
     */
    private $blogCategoryRepository;
    public function __construct()
    {
        parent::__construct();

        $this->blogCategoryRepository = app(BlogCategoryRepository::class);
    }

    public function index()
    {
        //$paginator = BlogCategory::paginate(5);
        $paginator = $this->blogCategoryRepository->getAllWithPaginate( 5);
        return view('blog.admin.categories.index', compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = new BlogCategory();
        $categoryList = $this->blogCategoryRepository->getForComboBox();
        return view('blog.admin.categories.edit', compact('item', 'categoryList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogCategoryCreateRequest $request)
    {
        $data = $request->input();
        $it = BlogCategory::all();
        if (empty($data['slug'])){
            $data['slug'] = \Str::slug($data['title']);
        }
        //if ($data['slug'] == )

        //Создаст обьект
        $item = (new BlogCategory())->create($data);

        if ($item){
            return redirect()->route('blog.admin.categories.edit', [$item->id])->with(['success'=> 'Успешно сохранено']);
        }
        else{
            return back()->withErrors(['msg'=> 'Ошибка сохранения'])->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @param BlogCategoryRepository $categoryRepository
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //$item = BlogCategory::findOrFail($id);

        //$categoryList = BlogCategory::all();
        $item = $this->blogCategoryRepository->getEdit($id);

        if (empty($item)){
            abort(404);
        }

        $categoryList = $this->blogCategoryRepository->getForComboBox();

        return view('blog.admin.categories.edit', compact('item', 'categoryList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlogCategoryUpdateRequest $request, $id)
    {
        //dd(__METHOD__, $request->all(), $id);
        //валидация
        //правила
        /* $rules = [
            'title' => 'required|min:5|max:200',
            'slug' => 'max:200',
            'description' => 'string|max:500|min:3',
            'parent_id' => 'required|integer|exists:blog_categories,id'
        ];*/

        //$validatedData = $this->validate($request, $rules);

        //$item = BlogCategory::find($id);
        $item = $this->blogCategoryRepository->getEdit($id);
        if (empty($item)) {
            return back()->withErrors(['msg' => "Запись id = [{$id}] не найдена"]) ->withInput();
        }
        $data = $request->all();
        if (empty($data['slug'])){
            $data['slug'] = \Str::slug($data['title']);
        }
        //$result = $item->fill($data)->save();
        $result = $item->update($data);

        if($result) {
            return redirect()->route('blog.admin.categories.edit', $item->id)->with(['success'=> 'Успешно сохранено']);
        }
        else{
            return back()->withErrors(['msg'=> 'Ошибка сохранения'])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
