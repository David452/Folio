<?php

namespace App\Controllers;

use App\Models\Project;
use App\Models\Tag;
use Cassandra\Date;
use Framework\Core\BaseController;
use Framework\Http\HttpException;
use Framework\Http\Request;
use Framework\Http\Responses\Response;
use App\Models\Category;

/**
 * Class HomeController
 * Handles actions related to the home page and other public actions.
 *
 * This controller includes actions that are accessible to all users, including a default landing page and a contact
 * page. It provides a mechanism for authorizing actions based on user permissions.
 *
 * @package App\Controllers
 */
class HomeController extends BaseController
{
    /**
     * Authorizes controller actions based on the specified action name.
     *
     * In this implementation, all actions are authorized unconditionally.
     *
     * @param string $action The action name to authorize.
     * @return bool Returns true, allowing all actions.
     */
    public function authorize(Request $request, string $action): bool
    {
        return true;
    }

    /**
     * Displays the default home page.
     *
     * This action serves the main HTML view of the home page.
     *
     * @return Response The response object containing the rendered HTML for the home page.
     */
    public function index(Request $request): Response
    {
        $categories = Category::getAll(orderBy: 'name');
        $tags = Tag::getAll(orderBy: 'name');
        $projects = Project::getAll(orderBy: 'created_at');
        return $this->html([
            'categories' => $categories,
            'tags' => $tags,
            'projects' => $projects,
        ]);
    }

    public function projects(Request $request): Response
    {
        return $this->html();
    }

    /**
     * Moje projekty (dashboard prihláseného používateľa) – zatiaľ statická ukážka.
     * TODO: dostupné iba prihlásenému používateľovi, načítať jeho projekty z DB
     */
    public function dashboard(Request $request): Response
    {
        if (!$this->user->isLoggedIn()) {
            // TODO: nejaka stranka
            echo "Not logged in";
        }
        $projects = Project::getAll(orderBy: 'created_at');
        return $this->html([
            'projects' => $projects,
        ]);
    }

    /**
     * Formulár projektu (vytvorenie / úprava základných údajov) – zatiaľ statická ukážka.
     * TODO: dostupné iba prihlásenému používateľovi, pri úprave iba autorovi projektu
     */
    public function projectForm(Request $request): Response
    {
        $id = $request->get('project_id');
        $project = Project::getOne($id); // TODO: Handle project not found
        $is_edit = $request->get('is_edit') ?? false;
        return $this->html([
            'project' => $project,
            'isEdit' => $is_edit,
        ]);
    }

    public function projectSave(Request $request): Response {
        if (!$request->isPost()) {
            throw new HttpException(405); // method not allowed
        }
        $now = date('Y-m-d H:i:s');

        $project = new Project();
        $project->title = trim((string)$request->post('title'));
        $project->short_description = trim((string)$request->post('short_description'));
        $project->is_public = (int)$request->post('is_public');
        $project->cover_image_path = '';
        $project->user_id = $this->user->getIdentity()->id;
        $project->created_at = $now;
        $project->updated_at = $now;
        $project->save();

        return $this->redirect($this->url('home.dashboard'));
    }

    public function projectUpdate(Request $request): Response {
        if (!$request->isPost()) {
            throw new HttpException(405); // method not allowed
        }

        $projectId = $request->post('project_id');
        if ($projectId === null) {
            throw new HttpException(404); // not found
        }
        $projectId = (int)$projectId;

        $now = date('Y-m-d H:i:s');
        $project = Project::getOne($projectId);
        $project->title = trim((string)$request->post('title'));
        $project->short_description = trim((string)$request->post('short_description'));
        $project->is_public = (int)$request->post('is_public');
        $project->cover_image_path = '';
        $project->user_id = $this->user->getIdentity()->id;
        $project->updated_at = $now;
        $project->save();

        return $this->redirect($this->url('home.dashboard'));
    }

    public function projectDelete(Request $request): Response
    {
        if (!$request->isPost()) {
            throw new HttpException(405);
        }

        $id = (int)$request->post('project_id');
        $project = Project::getOne($id);

        if ($project === null) {
            throw new HttpException(404);
        }

        $project->delete();

        return $this->redirect($this->url('home.dashboard'));
    }

    public function about(Request $request): Response
    {
        return $this->html();
    }

    public function terms(Request $request): Response
    {
        return $this->html();
    }

    public function contact(Request $request): Response
    {
        return $this->html();
    }
}
