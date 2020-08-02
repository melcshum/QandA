<answer :answer="{{ $answer }}" inline-template>
    <div class="media post">
        <vote :model="{{ $answer }}" name="answer"></vote>

        <div class="media-body">
            <form v-if="editing" @submit.prevent="update">

                <div class="form-group">
                    <textarea class="form-control" v-model="body" cols="80" rows="10" required></textarea>
                </div>
                <button class="btn btn-primary" :disabled="isInvalid">Update</button>
                <button class="btn btn-outline-secondary" type="button" @click="cancel">Cancal</button>
            </form>
            <div v-if="editing===false">
                <div v-html="bodyHtml"></div>

                <div class="row">
                    <div class="col-4">
                        @can('update', $answer)
                            <div class="ml-auto">
                                <a @click.prevent="edit" class="btn btn-sm btn-outline-info">Edit</a>
                            </div>

                        @endcan
                        @can('delete', $answer)
                            <button @click="destory" class="btn btn-sm btn-outline-danger">Delete</button>
                            {{-- <form class="form-delete" method="post"
                                        action="{{ route('questions.answers.destroy', [$question->id, $answer->id]) }}">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Are you sure?')">Delete</button>
                                    </form> --}}
                        @endcan
                    </div>
                    <div class="col-4"></div>
                    <div class="col-4">
                        <user-info :model="{{ $answer }}" label="Answered" />
                    </div>
                </div>

            </div>
        </div>

    </div>
</answer>
