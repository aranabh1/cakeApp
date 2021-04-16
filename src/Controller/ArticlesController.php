<?php

namespace App\Controller;

use App\Controller\AppController;

class ArticlesController extends AppController {

    public function index () {
        // die('hey'); // for debugging
        $this->loadComponent('Paginator');
        $articles = $this->Paginator->paginate($this->Articles->find()); // variable holds all articles
        $this->set('articles', $articles); // used by view
    }

    // override initialize()
    public function initialize() : void {
        parent::initialize();
        // you could add these to AppController also/instead
        $this->loadComponent('Paginator');
        $this->loadComponent('Flash'); // to display messages to user
    }

  

    public function add() {
        // create a new article
        $article = $this->Articles->newEmptyEntity(); // empty db table record (row)
        // debug($this-request->getData());
        // populate the entity
        if($this->request->is('post')) {
            $article = $this->Articles->patchEntity($article, $this->request->getData());
            $article->user_id = 1; // not used yet
            if($this->Articles->save($article)) { 
                $this->Flash->success('Article has been saved. ');
                return $this->redirect (['action' => 'index']);
            }
            else {
                $this->Flash->error('Article has NOT been saved. ');
            }
        // else not a post request
       $article->slug = $this->request->getData('title') . rand(); // make slug unique
        }
 
        $this->set('article', $article); 

    }

}