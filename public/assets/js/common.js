const call_frame = document.querySelector(".click_upload");
const vdo_upload = document.querySelector(".pr_vdo_uploader");
const close_vdo_tag = document.querySelector(".close");
const remove_dim_class = document.querySelector(".remove_dim_class");
const other_input = document.querySelectorAll(".others-input");
const nation_opt1 = document.querySelector("#nation_opt1");
const nation_opt2 = document.querySelector("#nation_opt2");
const policy_input = document.querySelector(".policy_input");
const submit_btn = document.querySelector(".submit_btn");
const never_input = document.querySelector("#never_input");
const visited_japan = document.querySelector(".visited_japan");
const c_form_radio = document.querySelectorAll(".c-form_radio");
const all_input = document.querySelectorAll(".all_input");
const inner_visited_japan_all_input = document.querySelectorAll(".visited_japan input[type=checkbox]");
window.onload = function () {
    if (never_input.checked) {
        visited_japan.classList.add("dis_ragion");
    }
    all_input.forEach((item) => {
        if (item.checked && item.classList.contains("policy_input")) {
            submit_btn.disabled = false;
            submit_btn.classList.add("show_pointer");
        }
        if(item.parentNode.nextElementSibling === null){
            return
        }
        if (item.checked) {
            item.parentNode.nextElementSibling.disabled = false;
            submit_btn.disabled = false;
            item.parentNode.nextElementSibling.classList.remove("dim");
        } else {
            remove_dim_class.classList.add("dim");
            item.parentNode.nextElementSibling.classList.add("dim");
            item.parentNode.nextElementSibling.disabled = true;
        }
    })
}
call_frame.addEventListener("click", () => {
    vdo_upload.style.display = "block"
})

close_vdo_tag.addEventListener("click", () => {
    vdo_upload.style.display = "none"
})
// radio handler
const radio_handler = (event) => {
    if (event.target.parentNode.nextElementSibling == null) {
        if (event.target.name == "nationality") {
            nation_opt1.value = "";
            nation_opt1.classList.add("dim");
        } else {
            nation_opt2.disabled = true;
            nation_opt2.value = "";
            nation_opt2.classList.add("dim");
        }
    } else {
        event.target.parentNode.nextElementSibling.disabled = false;
        event.target.parentNode.nextElementSibling.classList.remove("dim");
      }
}
//  checkbox handler
const checkbox_handler = (items) => {
    if (items && remove_dim_class.value == "") {
        remove_dim_class.disabled = false;
        remove_dim_class.classList.remove("dim");
    } else {
        remove_dim_class.value = ""
        remove_dim_class.classList.add("dim");
    }
}

other_input.forEach(item => {
    item.addEventListener("click", event => {
        if (event.target.tagName == "INPUT") {
            if (event.target.type == "checkbox") {
                const is_dim = remove_dim_class.classList.contains("dim")
                checkbox_handler(is_dim)
            } else {
               radio_handler(event)
            }
        }
    })
})
// for policy input and submit btn
policy_input.addEventListener("click", () => {
    if (policy_input.checked) {
        submit_btn.disabled = false;
        submit_btn.classList.add("show_pointer")
    } else {
        submit_btn.disabled = true;
        submit_btn.classList.remove("show_pointer")
    }
})
// if never
c_form_radio.forEach(item => {
    item.addEventListener("click", (event) => {
        if (event.target.id == 'never_input') {
            visited_japan.classList.add("dis_ragion");
            inner_visited_japan_all_input.forEach(item => {
                item.checked = false;
            })
        } else {
            visited_japan.classList.remove("dis_ragion");
        }
    } )
})