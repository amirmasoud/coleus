<?php

namespace App\Admin\Controllers;

use App\Models\User;
use Spatie\MediaLibrary\Models\Media;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class MediaController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Index')
            ->description('description')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Media);

        $grid->id('Id');
        $grid->model_type('Model type');
        $grid->model_id('Model id');
        $grid->collection_name('Collection name');
        $grid->name('Name');
        $grid->file_name('File name');
        $grid->mime_type('Mime type');
        $grid->disk('Disk');
        $grid->size('Size');
        $grid->manipulations('Manipulations');
        $grid->custom_properties('Custom properties');
        $grid->responsive_images('Responsive images');
        $grid->order_column('Order column');
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Media::findOrFail($id));

        $show->id('Id');
        $show->model_type('Model type');
        $show->model_id('Model id');
        $show->collection_name('Collection name');
        $show->name('Name');
        $show->file_name('File name');
        $show->mime_type('Mime type');
        $show->disk('Disk');
        $show->size('Size');
        $show->manipulations('Manipulations');
        $show->custom_properties('Custom properties');
        $show->responsive_images('Responsive images');
        $show->order_column('Order column');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Media);

        $form->select('model_type', 'Model type')->options(['App\Models\User' => 'User']);
        $form->select('model_id', 'Model id')->options(User::all()->pluck('name', 'id'));
        $form->text('collection_name', 'Collection name');
        $form->text('name', 'Name');
        $form->text('file_name', 'File name');
        $form->text('mime_type', 'Mime type');
        $form->text('disk', 'Disk');
        $form->text('size', 'Size');
        $form->text('order_column', 'Order column');

        return $form;
    }
}
