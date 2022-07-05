export default {
    mounted(current_element, binding) {
        //Слежка за тем находимся ли мы в самом низу страницы, для того чтобы догрузить еще посты
        console.log(binding);
        const options = {
            rootMargin: '0px',
            threshold: 1.0
        };
        const callback = (entries, observer) => {
            if(entries[0].isIntersecting){
                binding.value();
            }
        };
        const observer = new IntersectionObserver(callback, options);
        observer.observe(current_element);
    },
    name: 'intersection'
}