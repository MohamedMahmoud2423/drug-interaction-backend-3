@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="text-center mb-4">💊 MediAssist Bot</h2>
    <div class="card shadow rounded">
        <div class="card-body bg-light" id="chat-box" style="height: 350px; overflow-y: auto; padding: 1rem;">
            <!-- Messages will appear here -->
        </div>
        <div class="card-footer bg-white border-0">
            <form id="chat-form">
                <div class="input-group">
                    <input type="text" id="user-message" class="form-control form-control-lg" placeholder="Ask about drug interactions or EHR data..." autocomplete="off">
                    <button type="submit" class="btn btn-primary btn-lg px-4">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    #chat-box p {
        margin: 0.5rem 0;
        padding: 0.75rem;
        border-radius: 10px;
        max-width: 75%;
        word-wrap: break-word;
    }

    #chat-box p strong {
        display: block;
        margin-bottom: 0.25rem;
    }

    #chat-box .user {
        background-color: #d1e7dd;
        align-self: flex-end;
        text-align: right;
        margin-left: auto;
    }

    #chat-box .bot {
        background-color: #f8d7da;
        align-self: flex-start;
        text-align: left;
        margin-right: auto;
    }

    #chat-box {
        display: flex;
        flex-direction: column;
    }
</style>

<script>
document.getElementById("chat-form").addEventListener("submit", async function(e) {
    e.preventDefault();
    const inputField = document.getElementById("user-message");
    const input = inputField.value.trim();
    if (!input) return;

    const chatBox = document.getElementById("chat-box");

    chatBox.innerHTML += `<p class="user"><strong>You:</strong> ${input}</p>`;
    inputField.value = '';
    chatBox.scrollTop = chatBox.scrollHeight;

    const response = await fetch("/chatbot", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ message: input })
    });

    const data = await response.json();
    chatBox.innerHTML += `<p class="bot"><strong>MediAssist:</strong> ${data.reply}</p>`;
    chatBox.scrollTop = chatBox.scrollHeight;
});
</script>
@endsection
