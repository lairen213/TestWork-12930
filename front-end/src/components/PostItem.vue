<template>
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">{{post.title}}</h5>
      <p class="card-text description-text">{{post.description}}</p>
      <div class="text-end">
        <button @click="$emit('remove', post)" class="btn btn-primary">Удалить</button>&nbsp;
        <button @click="$router.push(`/posts/${post.id}`)" class="btn btn-primary">Детальнее</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    post: {
      type: Object,
      required: true
    }
  }
}
</script>

<style scoped>
.description-text{
  text-overflow: ellipsis;
  white-space: nowrap;
  overflow: hidden;
}
</style>