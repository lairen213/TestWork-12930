<template>
  <div>
    <div class="card mt-5 mb-5">
      <div class="card-body">
        <div v-if="!isUpdatingPost">
          <h5 class="card-title">{{this.post.title}}</h5>
          <p class="card-text">{{this.post.description}}</p>
        </div>

        <div v-else>
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
                maxlength="7800"
            ></textarea>
            <label for="descriptionTextarea">Описание</label>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <button class="btn btn-outline-info" @click="$router.go(-1)">Назад</button>&nbsp;
        <button class="btn btn-outline-warning" @click="changeFormPost" v-if="!isUpdatingPost">Редактировать</button>
        <button class="btn btn-outline-success" @click="updatePost" v-else>Сохранить</button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "PostIdPage",
  data() {
    return {
      axiosUrl: import.meta.env.VITE_URL,
      isUpdatingPost: false,
      post: {}
    }
  },
  methods: {
    changeFormPost(){ //переключаемся на редактирование
      this.isUpdatingPost = true;
    },
    async updatePost(){//редактирование поста, если все хорошо не переключаемся на просмотр поста
      if(!this.post.title || !this.post.description){
        alert('Название и описание не могут быть пустыми!');
      }else{
        const response = await axios.put(this.axiosUrl+'/posts/'+this.$route.params.id, {
          title: this.post.title,
          description: this.post.description
        });

        if(response.data.status === 'ok') {
          this.isUpdatingPost = false;
        }else{
          alert('Произошла ошибка! Попробуйте перезапустить страницу...');
        }
      }
    },
    async fetchPost(){//загрузка поста
      try {
        const response = await axios.get(this.axiosUrl+'/posts/'+this.$route.params.id);

        if(response.data.data) {
          this.post = response.data.data;
        }else {
          alert('Пост не был найден!');
        }
      } catch (e) {
        console.log(e);
        alert('Ошибка!');
      }
    }
  },
  mounted() {
    this.fetchPost()
  }
}
</script>

<style scoped>

</style>