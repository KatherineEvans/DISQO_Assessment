<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Traits\PaginatesResponseTrait;
use Illuminate\Http\Request;
use App\Http\Requests\CreateNoteApiRequest;
use App\Http\Requests\UpdateNoteApiRequest;

class NotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Note::thisUser();

        if($request->filled('title')) {
            $query = $query->where('title', $request->first_name);
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
        $note = Note::findOrFail($id);
        
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
        $note = Note::findOrFail($id);

        if (auth()->user()->id != $note->id) {
            return response()->json([
                'message' => 'Authorization Error',
                'errors' => [
                    'user_id' => ['This user does not have permission to update this note.']
                ]
            ], 401);
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
        $note->delete();
        
        return reponse(json_encode('Success'), 200);
    }
}
