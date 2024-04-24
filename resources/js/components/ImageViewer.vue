<template>
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Imagen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img :src="imageUrl" class="img-fluid centered-img" alt="Imagen">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ImageViewer",
    props: {
        imageUrl: String
    }
};
</script>

<style scoped>
.centered-img {
    display: block;
    margin: 0 auto;
}
</style>
