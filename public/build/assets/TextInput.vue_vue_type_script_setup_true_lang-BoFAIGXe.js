import{d,j as l,q as c,g as o,b as m,t as i,o as t,r as _,A as f,p as g,l as k,B as v}from"./app-CNpEUL5w.js";const b={class:"text-sm text-red-600 dark:text-red-400"},B=d({__name:"InputError",props:{message:{}},setup(u){return(e,r)=>l((t(),o("div",null,[m("p",b,i(e.message),1)],512)),[[c,e.message]])}}),y={class:"block text-sm font-medium text-gray-700 dark:text-gray-300"},h={key:0},x={key:1},M=d({__name:"InputLabel",props:{value:{}},setup(u){return(e,r)=>(t(),o("label",y,[e.value?(t(),o("span",h,i(e.value),1)):(t(),o("span",x,[_(e.$slots,"default")]))]))}}),$=d({__name:"TextInput",props:{modelValue:{required:!0},modelModifiers:{}},emits:["update:modelValue"],setup(u,{expose:e}){const r=f(u,"modelValue"),n=g(null);return k(()=>{var s,a;(s=n.value)!=null&&s.hasAttribute("autofocus")&&((a=n.value)==null||a.focus())}),e({focus:()=>{var s;return(s=n.value)==null?void 0:s.focus()}}),(s,a)=>l((t(),o("input",{class:"rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600","onUpdate:modelValue":a[0]||(a[0]=p=>r.value=p),ref_key:"input",ref:n},null,512)),[[v,r.value]])}});export{M as _,$ as a,B as b};
