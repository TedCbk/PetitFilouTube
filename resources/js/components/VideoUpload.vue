<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Upload</div>

                    <div class="card-body">
                        <input
                            type="file"
                            name="video"
                            id="video"
                            @change="fileInputChange"
                            v-if="!uploading"
                        />

                        <div id="video-form" v-if="uploading && !failed">
                            Form
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            uid: null,
            uploading: false,
            uploadingComplete: false,
            failed: false,
            title: 'Untitled',
            description: null,
            visibility: 'private',
        };
    },
    methods: {
        fileInputChange() {
            this.uploading = true;
            this.failed = false;

            this.file = document.getElementById('video').files[0];
            

        //    Upload a video
            this.store().then(() => {


            })
             // Store the metadata
            // Upload the video
        },
        store() {
            return this.$http.post('/videos', {
                title: this.title,
                description: this.description,
                visibility: this.visibility,
                extension: this.file.name.split('.').pop()
            }).then((response) => {
                this.uid = response.json().data.uid;
            });
        }
    },
    ready() {

    }
};
</script>
