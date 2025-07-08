@extends('layouts.topnav')

@section('title', 'Chat Narrativo')

@section('content')
<div class="container" id="narrative-app">
    <h1 class="mb-4">Crónicas del Dominio</h1>
    <div class="row">
        <div class="col-md-8">
            <div class="chat-box" style="height:300px; overflow-y:auto; background:#f7f7f7; padding:10px; border:1px solid #ccc;">
                <div v-for="msg in messages" class="mb-2">
                    <strong>@{{ msg.role }}:</strong> @{{ msg.content }}
                </div>
            </div>
            <form @submit.prevent="sendMessage" class="mt-3">
                <input type="text" v-model="input" class="form-control" placeholder="Escribe...">
                <button type="submit" class="btn btn-primary mt-2">Enviar</button>
            </form>
        </div>
        <div class="col-md-4" v-if="state">
            <div class="panel panel-default">
                <div class="panel-heading">Recursos</div>
                <table class="table table-sm">
                    <thead>
                        <tr><th>Tipo</th><th>Cant.</th><th>+día</th></tr>
                    </thead>
                    <tbody>
                        <tr v-for="res in resources" :key="res">
                            <td class="text-capitalize">@{{ res }}</td>
                            <td>@{{ state.status['resource_'+res] }}</td>
                            <td>@{{ Math.round(state.production_per_hour[res]*24) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('page-scripts')
<script src="https://unpkg.com/vue@3"></script>
<script>
const app = Vue.createApp({
    data() {
        return {messages: [], input: '', state: null, resources: ['platinum','food','lumber','mana','ore','gems','tech','boats']};
    },
    mounted() { this.fetchMessages(); this.fetchState(); },
    methods: {
        fetchMessages() {
            fetch('{{ url('narrative/messages') }}').then(r => r.json()).then(d => {this.messages = d;});
        },
        fetchState() {
            fetch('{{ url('narrative/state') }}').then(r => r.json()).then(d => {this.state = d;});
        },
        sendMessage() {
            fetch('{{ url('narrative/message') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({message: this.input})
            }).then(r => r.json()).then(d => {this.messages = d; this.input = ''; this.fetchState();});
        }
    }
});
app.mount('#narrative-app');
</script>
@endpush
