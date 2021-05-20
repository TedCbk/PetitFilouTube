<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Upload a new video</div>
                    <!-- upload Part -->
                    <div class="card-body">
                        <input
                            type="file"
                            name="video"
                            id="video"
                            @change="fileInputChange"
                            v-if="!uploading"
                        />

                        <div class="alert alert-danger" v-if="failed">
                            Something went wrong, please try again
                        </div>

                        <div id="video-form" v-if="uploading && !failed">
                            <div
                                class="alert alert-info"
                                v-if="!uploadingComplete"
                            >
                                Your video will be available at <a href=""></a>{{ $root.url }}/videos/{{ uid }}
                            </div>
                            <div
                                class="alert alert-info"
                                v-if="uploadingComplete"
                            >
                                Upload complete. Video is now processing.
                                <a href="/videos">Go to your videos</a>
                            </div>

                            <div class="progress" v-if="!uploadingComplete">
                                <div
                                    class="progress-bar"
                                    v-bind:style="{ width: fileProgress + '%' }"
                                ></div>
                            </div>

                            <div class="form-group">
                                <label for="title">Title</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="title"
                                />
                            </div>
                            <!-- Edit on Upload Part -->
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea
                                    class="form-control"
                                    v-model="description"
                                ></textarea>
                            </div>

                            <div class="form-group">
                                <label for="visibility">Visibility</label>
                                <select
                                    class="form-control"
                                    v-model="visibility"
                                >
                                    <option value="private">Private</option>
                                    <option value="unlisted">Unlisted</option>
                                    <option value="public">Public</option>
                                </select>
                            </div>

                            <span class="help-block text-right">{{
                                saveStatus
                            }}</span>
                            <button
                                class="btn btn-primary"
                                type="submit"
                                @click.prevent="update"
                            >
                                Save Changes
                            </button>
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
            title: "Untitled",
            description: null,
            visibility: "private",
            saveStatus: null,
            fileProgress: 0
        };
    },
    methods: {
        fileInputChange() {
            this.uploading = true;
            this.failed = false;

            this.file = document.getElementById("video").files[0];

            //    Upload a video
            this.store().then(
                () => {
                    var form = new FormData();

                    form.append("video", this.file);
                    form.append("uid", this.uid);

                    this.$http.post('/upload', form, {
                            progress: (e) => {
                                if (e.lengthComputable) {
                                    this.updateProgress(e)
                                }
                            }
                        })
                        .then(
                            () => {
                                this.uploadingComplete = true;
                            },
                            () => {
                                this.failed = true;
                            }
                        );
                },
                () => {
                    this.failed = true;
                }
            );
            // Store the metadata
            // Upload the video
        },
        store() {
            return this.$http
                .post('/videos', {
                    title: this.title,
                    description: this.description,
                    visibility: this.visibility,
                    extension: this.file.name.split(".").pop()
                })
                .then((response) => {
                    this.uid = response.data.uid;
                });
        },
        update() {
            this.saveStatus = "Saving Changes";

            return this.$http
                .put('/videos/' + this.uid, {
                    title: this.title,
                    description: this.description,
                    visibility: this.visibility
                })
                .then(
                    (response) => {
                        this.saveStatus = "Changes Saved";

                        setTimeout(() => {
                            this.saveStatus = null;
                        }, 3000);
                    },
                    () => {
                        this.saveStatus = "Failed to save changes";
                    }
                );
        },
        updateProgress(e) {
            e.percent = (e.loaded / e.total) * 100;
            this.fileProgress = e.percent;
        }
    },
    ready() {}
};
</script>
