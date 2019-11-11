<template>
    <div class="image-preview" v-bind:style="{'width':width_+'px', 'height': height_+'px'}">
        <img v-if="imageData.length > 0" class="preview" :src="imageData">
    </div>
</template>
<script>
    export default {
        name: "ImagePreview",
        props: [
            'imageData','width_','height_'
        ],
    }
</script>