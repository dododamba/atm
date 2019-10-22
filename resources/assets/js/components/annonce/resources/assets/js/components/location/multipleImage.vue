<template>
    <div  class="uploader"
         @dragenter="OnDragEnter"
         @dragleave="OnDragLeave"
         @dragover.prevent
         @drop="onDrop"
         :class="{dragging: isDragging }">

        <div class="upload-control" v-show="images.length || liste_old_images!=null">
            <label for="file">Ajouter Images</label>
        </div>


        <div v-show="!images.length || liste_old_images===null">
            <i class="fa fa-cloud-upload fa_upload"></i>
            <p>Déposez les images ici </p>
            <div>OU</div>
            <div class="file-input">
                <label for="file">Choisir</label>
                <input type="file" id="file" @change="onInputChange" multiple>
            </div>
        </div>

        <div class="images-preview" v-show="images.length || liste_old_images!==null">
            <div class="img-wrapper" v-for="(image, cle) in liste_old_images" :cle="cle">
                <img :src="image.nom" :alt="`Image Uplaoder ${cle}`">
                <div class="details">
                    <b-button variant="danger" size="sm"  v-b-tooltip.hover title="Supprimer cette image"
                              @click="deleteElement(cle)">
                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                    </b-button>
                </div>
            </div>
            <div class="img-wrapper" v-for="(image, index) in images" :key="index">
                <img :src="image" :alt="`Image Uplaoder ${index}`">
                <div class="details">
                    <b-button variant="danger" size="sm"  v-b-tooltip.hover title="Supprimer cette image"
                              @click="removeFile(index)">
                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                    </b-button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['old_images'],
        data () {
            return {
                isDragging: false,
                dragCount: 0,
                files: [],
                images: [],
                images_to_remove : [],
                liste_old_images : this.old_images === null ? [] : this.old_images
          }
        },
        methods: {

            deleteElement(cle) {
                this.images_to_remove.push(this.liste_old_images[cle].id);
                this.liste_old_images.splice(cle, 1);
                this.$root.$emit('images_to_remove' , this.images_to_remove);
            },
            removeFile(index) {
                this.files.splice(index,1);
                this.images.splice(index,1);

                this.$root.$emit('images' , this.images);
            },
            OnDragEnter(e) {
                e.preventDefault();

                this.dragCount++;
                this.isDragging = true;

                return false;
            },
            OnDragLeave(e) {
                e.preventDefault();
                this.dragCount--;

                if (this.dragCount <= 0)
                    this.isDragging = false;
            },
            onInputChange(e) {
                const files = e.target.files;

                Array.from(files).forEach(file => this.addImage(file));
            },
            onDrop(e) {
                e.preventDefault();
                e.stopPropagation();

                this.isDragging = false;

                const files = e.dataTransfer.files;

                Array.from(files).forEach(file => this.addImage(file));
            },
            addImage(file) {
                if (!file.type.match('image.*')) {
                    toast.fire({
                        type: 'error',
                        title: 'Erreur !',
                        html: `${file.name} n'est pas une image`
                    });
                    return;
                }

                this.files.push(file);

                const img = new Image(),
                    reader = new FileReader();

                reader.onload = (e) => this.images.push(e.target.result);

                reader.readAsDataURL(file);

                this.$root.$emit('images' , this.images);
            },

            getFileSize(size) {
                const fSExt = ['Bytes', 'KB', 'MB', 'GB'];
                let i = 0;

                while(size > 900) {
                    size /= 1024;
                    i++;
                }

                return `${(Math.round(size * 100) / 100)} ${fSExt[i]}`;
            }
        }
    }
</script>

<style lang="scss" scoped>
    .uploader {
        width: 100%;
        background: #0c2646;
        color: #fff;
        padding: 40px 15px;
        text-align: center;
        border-radius: 10px;
        border: 1px dashed #fff;
        font-size: 20px;
        position: relative;

        &.dragging {
            background: #fff;
            color: #b4dbed;
            border: 3px dashed #2196F3;

            .file-input label {
                background: #2196F3;
                color: #fff;
            }
        }

        .fa_upload {
            font-size: 50px;
        }

        .file-input {
            width: 200px;
            margin: auto;
            height: 50px;
            position: relative;

            label,
            input {
                background: #fff;
                color: #2196F3;
                width: 100%;
                position: absolute;
                left: 0;
                top: 0;
                padding: 10px;
                border-radius: 4px;
                margin-top: 7px;
                cursor: pointer;
            }

            input {
                opacity: 0;
                z-index: -2;
            }
        }

        .images-preview {
            display: flex;
            flex-wrap: wrap;
            margin-top: 20px;

            .img-wrapper {
                width: 160px;
                display: flex;
                flex-direction: column;
                margin: 10px;
                height: 150px;
                justify-content: space-between;
                background: #fff;
                box-shadow: 5px 5px 20px #3e3737;

                img {
                    max-height: 105px;
                }
            }

            .details {
                font-size: 12px;
                background: #fff;
                color: #000;
                display: flex;
                flex-direction: column;
                align-items: self-start;
                padding: 3px 6px;

                .name {
                    overflow: hidden;
                    height: 18px;
                }
            }
        }

        .upload-control {
            position: absolute;
            width: 100%;
            background: #fff;
            top: 0;
            left: 0;
            border-top-left-radius: 7px;
            border-top-right-radius: 7px;
            padding: 10px;
            padding-bottom: 4px;
            text-align: right;

            button, label {
                background: #0c2646;
                border-radius: 3px;
                color: #fff;
                font-size: 15px;
                cursor: pointer;
            }

            label {
                padding: 2px 5px;
                margin-right: 10px;
            }
        }
    }
</style>