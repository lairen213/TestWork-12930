import "bootstrap"
import "bootstrap/dist/css/bootstrap.css"
import { createApp } from 'vue'
import App from './App.vue'
import components_ui from './components/UI'
import directives from './directives'
import router from "./router/router"

const app = createApp(App);

//Глобальная регистрация для компонентов из папки UI
components_ui.forEach(component_ui => {
    app.component(component_ui.name, component_ui);//Передаем название компонента, а вторым передаем сам компонент
})

//Глобальная регистрация для директив, из папки directives
directives.forEach(directive => {
    app.directive(directive.name, directive)//Передаем название директивы, а вторым передаем саму директиву
})

app
    .use(router)
    .mount('#app')
