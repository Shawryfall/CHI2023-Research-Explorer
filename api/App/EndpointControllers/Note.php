<?php
 
namespace App\EndpointControllers;
/**
 * Controller class for managing notes in the application.
 *
 * This class extends the 'Endpoint' class and is responsible for handling
 * various HTTP methods (GET, POST, DELETE) related to notes. It includes
 * functionality for validating tokens, checking user existence, and performing
 * CRUD operations on notes.
 *
 * @author Patrick Shaw
 */ 
class Note extends Endpoint 
{
    /**
     * Constructs the Note object and processes the HTTP request.
     *
     * The constructor validates the user token, checks if the user exists,
     * and then processes the request based on the HTTP method. Supported
     * methods are GET, POST, and DELETE for note operations.
     *
     * @throws \App\ClientError For unsupported HTTP methods or authentication failures.
     */
    public function __construct()
    {
        $id = $this->validateToken();
        
        $this->checkUserExists($id);
 
        switch(\App\Request::method()) 
        {
            case 'GET':
                $data = $this->getNote($id);
                break;
            case 'POST':
                $data = $this->postNote($id);
                break;
            case 'DELETE':
                $data = $this->deleteNote($id);
                break;
            default:
                throw new \App\ClientError(405);
                break;
        }
        parent::__construct($data);
    }
 
    /**
     * Validates the JWT token from the request.
     *
     * Validates the token using JWT standards and extracts the user ID from it.
     * It throws an error if the token is invalid or expired.
     *
     * @return string The user's ID extracted from the token.
     * @throws \App\ClientError If the token is invalid or expired.
     */
    private function validateToken()
    {
        $secretkey = SECRET;
                
        $jwt = \App\REQUEST::getBearerToken();
 
        try {
            $decodedJWT = \FIREBASE\JWT\JWT::decode($jwt, new \FIREBASE\JWT\Key($secretkey, 'HS256'));
        } catch (\Exception $e) {
            throw new \App\ClientError(401);
        }
 
        if (!isset($decodedJWT->exp) || !isset($decodedJWT->sub)) { 
            throw new \App\ClientError(401);
        }
 
        return $decodedJWT->sub;
    }
 
    /**
     * Processes the 'note' parameter from the request.
     *
     * Checks if the 'note' parameter exists and is within the length limit.
     * It sanitizes the note content before returning.
     *
     * @return string The sanitized note content.
     * @throws \App\ClientError If the 'note' parameter is missing or too long.
     */
    private function note() 
    {
        if (!isset(\App\REQUEST::params()['note']))
        {
            throw new \App\ClientError(422);
        }
 
        if (mb_strlen(\App\REQUEST::params()['note']) > 255)
        {
            throw new \App\ClientError(422);
        }
 
       $note = \App\REQUEST::params()['note'];
       return htmlspecialchars($note);
    }
 
    /**
     * Retrieves notes for a user.
     *
     * If a 'content_id' is specified in the request, it returns the note for
     * that specific content; otherwise, it returns all notes for the user.
     *
     * @param string $id The user's ID.
     * @return array An array of notes.
     */
    private function getNote($id)
    {

        if (isset(\App\REQUEST::params()['content_id']))
        {
            $content_id = \App\REQUEST::params()['content_id'];
 
            if (!is_numeric($content_id))
            {
                throw new \App\ClientError(422);
            }
 
            $sql = "SELECT * FROM notes WHERE user_id = :id AND content_id = :content_id";
            $sqlParams = [':id' => $id, 'content_id' => $content_id];
        } else {
            $sql = "SELECT * FROM notes WHERE user_id = :id";
            $sqlParams = [':id' => $id];
        }
 
        $dbConn = new \App\Database(USERS_DATABASE);
        
        $data = $dbConn->executeSQL($sql, $sqlParams);
        
        return $data;
            
    }
 
    /**
     * Handles creating or updating a note.
     *
     * Depending on whether a note for the specified content exists, this method
     * either creates a new note or updates the existing one.
     *
     * @param string $id The user's ID.
     * @return array An empty array indicating successful operation.
     * @throws \App\ClientError If required parameters are missing or invalid.
     */
    private function postNote($id)
    {
        if (!isset(\App\REQUEST::params()['content_id']))
        {
            throw new \App\ClientError(422);
        }
 
        $content_id = \App\REQUEST::params()['content_id'];
        
        if (!is_numeric($content_id))
        {
            throw new \App\ClientError(422);
        }
 
        $note = $this->note();
 
        $dbConn = new \App\Database(USERS_DATABASE);
 
        $sqlParams = [':id' => $id, 'content_id' => $content_id];
        $sql = "SELECT * FROM notes WHERE user_id = :id AND content_id = :content_id";
        $data = $dbConn->executeSQL($sql, $sqlParams);
 
        if (count($data) === 0) {
            $sql = "INSERT INTO notes (user_id, content_id, note) VALUES (:id, :content_id, :note)";
        } else {
            $sql = "UPDATE notes SET note = :note WHERE user_id = :id AND content_id = :content_id";
        }
 
        $sqlParams = [':id' => $id, 'content_id' => $content_id, 'note' => $note];
        $data = $dbConn->executeSQL($sql, $sqlParams);
     
        return [];
    }
 
 
    /**
     * Deletes a note for a specific content.
     *
     * This method deletes a note associated with a given 'content_id' for the user.
     *
     * @param string $id The user's ID.
     * @return array The result of the delete operation.
     * @throws \App\ClientError If required parameters are missing or invalid.
     */
    private function deleteNote($id)
    {
        if (!isset(\App\REQUEST::params()['content_id']))
        {
            throw new \App\ClientError(422);
        }
 
        $content_id = \App\REQUEST::params()['content_id'];
        
        if (!is_numeric($content_id))
        {
            throw new \App\ClientError(422);
        }
 
        $dbConn = new \App\Database(USERS_DATABASE);
        $sql = "DELETE FROM notes WHERE user_id = :id AND content_id = :content_id";
        $sqlParams = [':id' => $id, 'content_id' => $content_id];
        $data = $dbConn->executeSQL($sql, $sqlParams);
        return $data;
    }
    /**
     * Checks if a user exists in the database.
     *
     * This method verifies the existence of a user by their ID. It throws an error
     * if the user does not exist.
     *
     * @param string $id The user's ID to check.
     * @throws \App\ClientError If the user does not exist.
     */
    private function checkUserExists($id)
    {
        $dbConn = new \App\Database(USERS_DATABASE);
        $sql = "SELECT id FROM account WHERE id = :id";
        $sqlParams = [':id' => $id];
        $data = $dbConn->executeSQL($sql, $sqlParams);
        if (count($data) != 1) {
            throw new \App\ClientError(401);
        }
    }
}