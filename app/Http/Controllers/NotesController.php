<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Traits\PaginatesResponseTrait;
use Illuminate\Http\Request;
use App\Http\Requests\NoteApiRequest;
use Illuminate\Foundation\Validation\ValidatesRequests;

class NotesController extends Controller
{
    use PaginatesResponseTrait, ValidatesRequests;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Note::thisUser();

        if($request->filled('title')) {
            $query = $query->where('title', $request->title);
        }

        if($request->filled('created_at')) {
            $query = $query->where('created_at', $request->created_at);
        }

        return $this->returnPaginatedResponse($query, $request->pagination);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NoteApiRequest $request)
    {
        $note = new Note;
        $note->title = $request->title;
        $note->note = $request->note;
        $note->user_id = auth()->user()->id;
        $note->save();

        return response()->json([
            'data' => $note,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $note = Note::find($id);
        
        if (!$note) {
            return $this->noteNotFound($id);
        }

        if (auth()->user()->id != $note->user_id) {
            return $this->userNotAuthorized();
        }

        return response()->json([
            'data' => $note,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(NoteApiRequest $request, $id)
    {
        $note = Note::find($id);

        if (!$note) {
            return $this->noteNotFound($id);
        }

        if (auth()->user()->id != $note->user_id) {
            return $this->userNotAuthorized();
        }

        $note->title = $request->title;
        $note->note = $request->note;
        $note->updated_at = now();
        $note->save();

        return response()->json([
            'data' => $note,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $note = Note::findOrFail($id);

        if (!$note) {
           return $this->noteNotFound($id);
        }

        if (auth()->user()->id != $note->user_id) {
            return $this->userNotAuthorized();
        }

        $note->delete();
        
        return response()->json([
            'success' => true
        ]);
    }

    // Note not found response
    private function noteNotFound($id) {

        return response()->json([
            'message' => 'Not Found',
            'errors' => [
                'id' => ['A note with ID '.$id.' has not been found.']
            ]
        ], 404);

    }

    // Not authorized response
    private function userNotAuthorized() {

        return response()->json([
            'message' => 'Authorization Error',
            'errors' => [
                'id' => ['This user does not have permission to view, updated, or delete this note.']
            ]
        ], 401);

    }
}
