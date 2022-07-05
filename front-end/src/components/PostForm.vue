<template>
  <div class="modal fade" id="createPostModal" tabindex="-1" aria-labelledby="createPostModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createPostModalLabel">Создать пост</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="form-floating">
            <input
                id="nameInput"
                type="text"
                class="form-control"
                placeholder="Название"
                v-focus
                v-model="post.title"
                maxlength="240"
            >
            <label for="nameInput">Название</label>
          </div>
          <br>
          <div class="form-floating">
            <textarea
                type="text"
                class="form-control"
                placeholder="Описание"
                v-model="post.description"
                id="descriptionTextarea"
                maxlength="7900"
            ></textarea>
            <label for="descriptionTextarea">Описание</label>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="createPost">Создать</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data(){
    return{
      post: {
        title: '',
        description: ''
      }
    }
  },
  methods: {
    createPost(){
      this.$emit('create', this.post);
      this.post = {
        title: '',
        description: ''
      }
    }
  }
}
</script>

<style scoped>

</style>