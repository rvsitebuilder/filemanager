try {
    window.$ = window.jQuery = require("jquery");
} catch (e) {}

/********************************************** */
import Vue from "vue";
import Vuex from "vuex";
import FileManager from "laravel-file-manager";

Vue.config.devtools = true;
Vue.use(Vuex);

// create Vuex store, if you don't have it
const store = new Vuex.Store();
Vue.use(FileManager, { store });

window.fm = new Vue({
    el: "#fm",
    store,
    template:
        '<file-manager v-bind:settings="settings" v-on=""></file-manager>',
    data: {
        settings: {
            headers: { "X-CSRF-TOKEN": Laravel.csrfToken }, // overwrite default header Axios},
            baseUrl: wex.url.baseUrl + "/admin/filemanager/",
            windowsConfig: select_path ? 1 : 2
        },
        sharedState: store.state.fm.left
    },
    mounted() {
        this.$store.watch(
            state => state.fm.left.selectedDisk,
            (newValue, oldValue) => {

                // alert("0");
                // console.log("0 --> state.fm.left.selectedDisk");

                if (newValue == select_disk) {

                    this.$store.dispatch(`fm/left/selectDirectory`, {
                        path: select_path,
                        history: true
                    });


                  
                }
            }
        );

        this.$store.watch(
            state => state.fm.left.selectedDirectory,
            (newValue, oldValue) => {
                let aclReadonly = false;
                let directories = (this.sharedState.directories.length == 0)
                                    ?this.sharedState.files
                                    :this.sharedState.directories;

                if (directories.length != 0) {
                    aclReadonly = directories.every(Value => {
                        return Value.acl == 1;
                    });
                }
                
                $(".breadcrumb .breadcrumb-status").remove();

                if (aclReadonly) {
                    $(".breadcrumb").append(
                        `<li class="breadcrumb-status" >
                            <span class="badge badge-warning mx-2">Read only</span>
                        </li>`);
                }

                if (oldValue == null && select_disk == "apps") {
                    this.$store.dispatch(`fm/left/selectDirectory`, {
                        path: select_path,
                        history: true
                    });
                }
            }
        );

        if (select_path) {
            $("#fm-frame .justify-content-between:first>div:last").append(
                '<div role="group" class="btn-group"><button type="button" id="home" title="Home" class="btn btn-secondary"><i class="fas fa-home"></i></button></div>'
            );
        }
    }
});

$("#home").click(function() {
    window.location.replace(wex.url.baseUrl + "/admin/filemanager");
});
