<?php

namespace App\Controllers;

use Framework\Core\BaseController;
use Framework\Http\HttpException;
use Framework\Http\Request;
use Framework\Http\Responses\Response;
use App\Models\Category;
use App\Models\Tag;

/**
 * Class AdminController
 *
 * This controller manages admin-related actions within the application.It extends the base controller functionality
 * provided by BaseController.
 *
 * @package App\Controllers
 */
class AdminController extends BaseController
{
    /**
     * Authorizes actions in this controller.
     *
     * This method checks if the user is logged in, allowing or denying access to specific actions based
     * on the authentication state.
     *
     * @param string $action The name of the action to authorize.
     * @return bool Returns true if the user is logged in; false otherwise.
     */
    public function authorize(Request $request, string $action): bool
    {
        return $this->user->isLoggedIn() && $this->user->getIdentity()->role === 'admin';
    }

    /**
     * Displays the index page of the admin panel.
     *
     * This action requires authorization. It returns an HTML response for the admin dashboard or main page.
     *
     * @return Response Returns a response object containing the rendered HTML.
     */
    public function index(Request $request): Response
    {
        $categories = Category::getAll(orderBy: 'name');
        $tags = Tag::getAll(orderBy: 'name');

        return $this->html([
            'categories' => $categories,
            'tags' => $tags
        ], 'tags');
    }

    public function categoryCreate(Request $request): Response
    {
        if (!$request->isPost()) {
            throw new HttpException(405);
        }

        $category = new Category();
        $category->name = $this->categoryName($request->post('name'));
        $category->save();

        return $this->redirect($this->url('admin.index'));
    }

    public function categoryUpdate(Request $request): Response
    {
        if (!$request->isPost()) {
            throw new HttpException(405);
        }

        $category = Category::getOne($this->postId($request, 'id'));
        if ($category === null) {
            throw new HttpException(404);
        }

        $category->name = $this->categoryName($request->post('name'));
        $category->save();

        return $this->redirect($this->url('admin.index'));
    }

    public function categoryDelete(Request $request): Response
    {
        if (!$request->isPost()) {
            throw new HttpException(405);
        }

        $category = Category::getOne($this->postId($request, 'id'));
        if ($category === null) {
            throw new HttpException(404);
        }
        if (Tag::getCount('category_id = ?', [$category->id]) > 0) {
            throw new HttpException(409, 'Kategóriu so štítkami nie je možné zmazať.');
        }

        $category->delete();

        return $this->redirect($this->url('admin.index'));
    }

    public function tagCreate(Request $request): Response
    {
        if (!$request->isPost()) {
            throw new HttpException(405);
        }

        $name = $this->tagName($request->post('name'));
        $category = Category::getOne($this->postId($request, 'category_id'));
        if ($category === null) {
            throw new HttpException(404);
        }

        $tag = new Tag();
        $tag->name = $name;
        $tag->category_id = $category->id;
        $tag->save();

        return $this->redirect($this->url('admin.index'));
    }

    public function tagUpdate(Request $request): Response
    {
        if (!$request->isPost()) {
            throw new HttpException(405);
        }

        $tag = Tag::getOne($this->postId($request, 'id'));
        if ($tag === null) {
            throw new HttpException(404);
        }

        $category = Category::getOne($this->postId($request, 'category_id'));
        if ($category === null) {
            throw new HttpException(404);
        }

        $tag->name = $this->tagName($request->post('name'));
        $tag->category_id = $category->id;
        $tag->save();

        return $this->redirect($this->url('admin.index'));
    }

    public function tagDelete(Request $request): Response
    {
        if (!$request->isPost()) {
            throw new HttpException(405);
        }

        $tag = Tag::getOne($this->postId($request, 'id'));
        if ($tag === null) {
            throw new HttpException(404);
        }

        $tag->delete();

        return $this->redirect($this->url('admin.index'));
    }

    private function postId(Request $request, string $key): int
    {
        $value = $request->post($key);
        $id = is_scalar($value) ? filter_var($value, FILTER_VALIDATE_INT) : false;
        if ($id === false || $id < 1) {
            throw new HttpException(400);
        }

        return $id;
    }

    private function tagName(mixed $value): string
    {
        if (!is_string($value)) {
            throw new HttpException(400);
        }

        $name = trim($value);
        $length = preg_match_all('/./us', $name);
        if ($name === '' || $length === false || $length > 64) {
            throw new HttpException(400);
        }

        return $name;
    }

    private function categoryName(mixed $value): string
    {
        if (!is_string($value)) {
            throw new HttpException(400);
        }

        $name = trim($value);
        $length = preg_match_all('/./us', $name);
        if ($name === '' || $length === false || $length > 64) {
            throw new HttpException(400);
        }

        return $name;
    }
}
