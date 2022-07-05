<template>
  <div>
    <h1 class="mt-3">Посты:</h1>
    <div class="row">
      <!-- Search by name of post-->
      <div class="col-12">
        <input
            type="text"
            class="form-control"
            placeholder="Поиск по названию"
            v-focus
            v-model="searchQuery"
        >
      </div>

      <!-- Create post and filters -->
      <div class="col-6 mt-2">
        <button
            type="button"
            class="btn btn-outline-success float-start"
            data-bs-toggle="modal"
            data-bs-target="#createPostModal"
        >
          Создать пост
        </button>
      </div>

      <div class="col-6 mt-2">
        <my-select
            class="float-end"
            v-model="selectedSort"
            :options="sortOptions"
        />
      </div>

      <!-- DIALOG CREATE POST -->
      <post-form @create="createPost"/>

      <!-- POSTS LIST -->
      <div class="col-12 mt-3">
        <hr>
        <post-list
            :posts="sortedAndSearchedPosts"
            @remove="removePost"
            v-if="!isPostsLoading"
        />
        <div v-else>
          Загрузка постов
        </div>
      </div>

      <!-- observer for more loading of posts -->
      <div v-intersection="loadMorePosts" ref="observer"></div>
      <div v-show="isPostsMoreLoading" class="load_more_posts"></div>
    </div>
  </div>
</template>

<script>
import PostForm from "@/components/PostForm.vue";
import PostList from "@/components/PostList.vue";
import axios from "axios";

export default {
  components: {
    PostForm, PostList
  },
  data(){
    return {
      posts: [],
      axiosUrl: import.meta.env.VITE_URL,
      isPostsLoading: false,
      isPostsMoreLoading: false,
      selectedSort: '',
      searchQuery: '',
      page: 1,
      limit: 5,
      totalPages: 0,
      sortOptions: [
        {value: 'title', name: 'По названию'},
        {value: 'description', name: 'По описанию'}
      ]
    }
  },
  computed: {
    sortPosts(){
      return [...this.posts.sort((post1, post2) => {
        return post1[this.selectedSort]?.localeCompare(post2[this.selectedSort])//сравниваем название одного поста с другим(либо же описание сравниваем)
      })]
    },
    sortedAndSearchedPosts(){
      return this.sortPosts.filter(post => post.title.toLowerCase().includes(this.searchQuery.toLowerCase()))//вызываем так же и отсортированый массив, на тот случай если человек не будет искать, а просто отсортирует массив
    }
  },
  methods: {
    async createPost(post){
      const response = await axios.post(this.axiosUrl+'/post-create', {
        title: post.title,//this.page,
        description: post.description,//this.limit
      });

      if(response.data.status === 'ok') {
        post.id = response.data.data;
        this.posts.push(post);
      }else {
        alert('Укажите все поля!');
      }
    },
    async removePost(post){
      const response = await axios.delete(this.axiosUrl+'/posts/'+post.id);
      if(response.data.status === 'ok')
        this.posts = this.posts.filter(p => p.id !== post.id);//Через фильтр получаемя новый отфильтрованый массив, но перезаписываем уже существующий и записываем только те посты у которых id не равый переданому
      else
        alert('Произошла ошибка, попробуйте перезапустить страницу');
    },
    async loadMorePosts(){//догрузка постов если дольши вниз на страницу
      if(this.totalPages != this.page) { //если все посты загружены то не догружаем
        try {
          this.page += 1;
          this.isPostsMoreLoading = true;
          const response = await axios.get(this.axiosUrl + '/posts', {
            params: {
              _page: this.page,
              _limit: this.limit
            }
          });
          this.totalPages = response.data.total_pages;
          this.posts = [...this.posts, ...response.data.data];
          this.isPostsMoreLoading = false;
        } catch (e) {
          console.log(e);
          alert('Ошибка!');
        }
      }
    },
    async fetchPosts(){
      try {
        this.isPostsLoading = true;
        const response = await axios.get(this.axiosUrl+'/posts', {
          params: {
            _page: this.page,//this.page,
            _limit: this.limit,//this.limit
          }
        });
        this.totalPages = response.data.total_pages;//Math.ceil(response.headers['x-total-count'] / this.limit)
        this.posts = response.data.data;
      } catch (e){
        console.log(e);
        alert('Ошибка!');
      } finally {
        this.isPostsLoading = false;
      }
    }
  },
  mounted() {
    this.fetchPosts();
  }
}
</script>

<style>
.load_more_posts{
  width: 200px;
  height: 200px;
  z-index: 1;
  overflow: visible;
  background: #fff url('https://anmdecolombia.org.co/wp-content/plugins/interactive-3d-flipbook-powered-physics-engine/assets/images/light-loader.gif') no-repeat center center;
}
</style>