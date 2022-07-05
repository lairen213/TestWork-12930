<template>
  <h3>Список постов</h3>
  <transition-group name="post-list">
      <post-item
          class="mb-3"
          v-for="post in posts"
          :post="post"
          :key="post.id"
          @remove="$emit('remove', post)"
      />
  </transition-group>

</template>

<script>
import PostItem from "./PostItem.vue";

export default {
  components: {
    PostItem
  },
  props: {
    posts: {
      type: Array,
      //default...
      required: true
    }
  }
}
</script>

<style scoped>
.post-list-item{
  display: inline-block;
  margin-top: 10px;
}
.post-list-enter-active,
.post-list-leave-active{
  transition: all 0.3s ease;
}
.post-list-enter-from,
.post-list-leave-to{
  opacity: 0;
  transform: translateX(130px);
}
.post-list-move {
  transition: transform 0.3s ease;
}
</style>