<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $conversations = Auth::user()->conversations()
            ->with(['users' => function($q) {
                $q->where('id', '!=', Auth::id());
            }, 'messages' => function($q) {
                $q->latest()->limit(1);
            }])
            ->latest('updated_at')
            ->get();

        return view('backend.chat.index', compact('conversations'));
    }

    public function show(Conversation $conversation)
    {
        $this->authorize('view', $conversation);

        $conversation->load(['users' => function($q) {
            $q->where('id', '!=', Auth::id());
        }]);

        $conversation->users()->updateExistingPivot(Auth::id(), [
            'last_read_at' => now()
        ]);

        $messages = $conversation->messages()
            ->with('user')
            ->latest()
            ->paginate(20);

        return view('backend.chat.show', compact('conversation', 'messages'));
    }

    public function storeMessage(Request $request, Conversation $conversation)
    {
        $this->authorize('view', $conversation);
    
        $request->validate([
            'body' => 'required|string|max:2000',
        ]);
    
        $message = $conversation->messages()->create([
            'user_id' => Auth::id(),
            'body' => $request->body,
        ]);
    
        broadcast(new MessageSent($message))->toOthers();
    
        return response()->json($message);
    }

    public function createDirectChat(User $user)
    {
        $conversation = Auth::user()->conversations()
            ->whereHas('users', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->where('is_group', false)
            ->first();

        if (!$conversation) {
            $conversation = Conversation::create(['is_group' => false]);
            $conversation->users()->attach([Auth::id(), $user->id]);
        }

        return redirect()->route('backend.chat.show', $conversation);
    }

    public function createGroupChat(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'participants' => 'required|array|min:1',
            'participants.*' => 'exists:users,id',
        ]);

        $conversation = Conversation::create([
            'name' => $request->name,
            'is_group' => true,
            'created_by' => Auth::id(),
        ]);

        $participants = array_unique(array_merge($request->participants, [Auth::id()]));
        $conversation->users()->attach($participants);

        return redirect()->route('backend.chat.show', $conversation);
    }

    public function addParticipants(Request $request, Conversation $conversation)
    {
        $this->authorize('manage', $conversation);

        $request->validate([
            'participants' => 'required|array|min:1',
            'participants.*' => 'exists:users,id',
        ]);

        $conversation->addParticipants($request->participants);

        return redirect()->back()->with('success', 'Participants added successfully');
    }

    public function removeParticipant(Conversation $conversation, User $user)
    {
        $this->authorize('manage', $conversation);

        $conversation->removeParticipant($user->id);

        return redirect()->back()->with('success', 'Participant removed successfully');
    }
}