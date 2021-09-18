<?php

use Model\Boosterpack_model;
use Model\Post_model;
use Model\User_model;
use Model\Login_model;
use Model\Comment_model;

/**
 * Created by PhpStorm.
 * User: mr.incognito
 * Date: 10.11.2018
 * Time: 21:36
 */
class Main_page extends MY_Controller
{

    public function __construct()
    {

        parent::__construct();

        if (is_prod())
        {
            die('In production it will be hard to debug! Run as development environment!');
        }
    }

    public function index()
    {
        $user = User_model::get_user();

        App::get_ci()->load->view('main_page', ['user' => User_model::preparation($user, 'default')]);
    }

    public function get_all_posts()
    {
        $posts =  Post_model::preparation_many(Post_model::get_all(), 'default');
        return $this->response_success(['posts' => $posts]);
    }

    public function get_boosterpacks()
    {
        $posts =  Boosterpack_model::preparation_many(Boosterpack_model::get_all(), 'default');
        return $this->response_success(['boosterpacks' => $posts]);
    }

    public function login()
    {
        // TODO: task 1, аутентификация
        $login = App::get_ci()->input->post('login');
        $password = App::get_ci()->input->post('password');
        $is_user = User_model::find_user_by_email($login, $password);

        if ($is_user->is_loaded())
        {
            $user = User_model::preparation(Login_model::login($is_user->get_id()), 'main_page');

            return $this->response_success(['user' => $user]);
        }
    }

    public function logout()
    {
        // TODO: task 1, аутентификация
        Login_model::logout();

        header('Location: /');
    }

    public function comment()
    {

        // TODO: task 2, комментирование
        $data = ['user_id' => User_model::get_user()->get_id(),
                'assign_id' => App::get_ci()->input->post('postId'),
                'text' => App::get_ci()->input->post('commentText')];

        return Comment_model::create($data);
    }

    public function like_comment(int $comment_id)
    {
        // TODO: task 3, лайк комментария
    }

    public function like_post(int $post_id)
    {
        // TODO: task 3, лайк поста
    }

    public function add_money()
    {
        // TODO: task 4, пополнение баланса

        $sum = (float)App::get_ci()->input->post('sum');

    }

    public function get_post(int $post_id) {
        // TODO получения поста по id
        $post = new Post_model($post_id);

        $data = Post_model::preparation($post, 'full_info');

        return $this->response_success(['post' => $data]);
    }

    public function buy_boosterpack()
    {
        // Check user is authorize
        if ( ! User_model::is_logged())
        {
            return $this->response_error(System\Libraries\Core::RESPONSE_GENERIC_NEED_AUTH);
        }

        // TODO: task 5, покупка и открытие бустерпака
    }





    /**
     * @return object|string|void
     */
    public function get_boosterpack_info(int $bootserpack_info)
    {
        // Check user is authorize
        if ( ! User_model::is_logged())
        {
            return $this->response_error(System\Libraries\Core::RESPONSE_GENERIC_NEED_AUTH);
        }


        //TODO получить содержимое бустерпака
    }
}
