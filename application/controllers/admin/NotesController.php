<?php
namespace application\controllers\admin;
use application\models\Note;
use ItForFree\SimpleMVC\Config;

/* 
 *   Class-controller notes
 * 
 * 
 */

class NotesController extends \ItForFree\SimpleMVC\MVC\Controller
{
    
    public string $layoutPath = 'admin-main.php';
    
    
    public function indexAction()
    {
        $Note = new Note();

        $noteId = $_GET['id'] ?? null;
        
        if ($noteId) { // если указан конктреный пользователь
            $viewNotes = $Note->getById($_GET['id']);
            $this->view->addVar('viewNotes', $viewNotes);
            $this->view->render('note/view-item.php');
        } else { // выводим полный список
            
            $notes = $Note->getList()['results'];
            $this->view->addVar('notes', $notes);
            $this->view->render('note/index.php');
        }
    }
    
    /**
     * Выводит на экран форму для создания новой статьи (только для Администратора)
     */
    public function addAction()
    {
        $Url = Config::get('core.router.class');
        if (!empty($_POST)) {
            if (!empty($_POST['saveNewNote'])) {
                $Note = new Note();
                $newNotes = $Note->loadFromArray($_POST);
                $newNotes->insert(); 
                $this->redirect($Url::link("admin/notes/index"));
            } 
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/notes/index"));
            }
        }
        else {
            $addNoteTitle = "Добавление новой заметки";
            $this->view->addVar('addNoteTitle', $addNoteTitle);
            
            $this->view->render('note/add.php');
        }
    }
    
    /**
     * Выводит на экран форму для редактирования статьи (только для Администратора)
     */
    public function editAction()
    {
        $id = $_GET['id'];
        $Url = Config::get('core.router.class');
        
        if (!empty($_POST)) { // это выполняется нормально.
            
            if (!empty($_POST['saveChanges'] )) {
                $Note = new Note();
                $newNotes = $Note->loadFromArray($_POST);
                $newNotes->update();
                $this->redirect($Url::link("admin/notes/index&id=$id"));
            } 
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/notes/index&id=$id"));
            }
        }
        else {
            $Note = new Note();
            $viewNotes = $Note->getById($id);
            
            $editNoteTitle = "Редактирование заметки";
            
            $this->view->addVar('viewNotes', $viewNotes);
            $this->view->addVar('editNoteTitle', $editNoteTitle);
            
            $this->view->render('note/edit.php');   
        }
        
    }
    
    /**
     * Выводит на экран предупреждение об удалении данных (только для Администратора)
     */
    public function deleteAction()
    {
        $id = $_GET['id'];
        $Url = Config::get('core.router.class');
        
        if (!empty($_POST)) {
            if (!empty($_POST['deleteNote'])) {
                $Note = new Note();
                $newNotes = $Note->loadFromArray($_POST);
                $newNotes->delete();
                
                $this->redirect($Url::link("admin/notes/index"));
              
            }
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/notes/edit&id=$id"));
            }
        }
        else {
            
            $Note = new Note();
            $deletedNote = $Note->getById($id);
            $deleteNoteTitle = "Удалить заметку?";
            
            $this->view->addVar('deleteNoteTitle', $deleteNoteTitle);
            $this->view->addVar('deletedNote', $deletedNote);
            
            $this->view->render('note/delete.php');
        }
    }
    
    
}