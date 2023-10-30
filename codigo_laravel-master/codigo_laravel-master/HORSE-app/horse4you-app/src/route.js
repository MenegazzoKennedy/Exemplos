import Vue from "vue";
import Router from "vue-router";
import { userKey } from "@/global";
import Comments from "./components/Modals/Comments";
import Offline from "./components/Modals/Offline";
import ThankYou from "./components/Modals/ThankYou";
import Splash from "./components/Modals/Splash";
import Login from "./components/Login/Login";
import LoginEmail from "./components/Login/LoginEmail";
import LoginDate from "./components/Login/LoginDate";
import Register from "./components/Register/Register";
import Category from "./components/Category/Category";
import RecoverPassword from "./components/RecoverPassword/RecoverPassword";
import RecoverCode from "./components/RecoverPassword/RecoverCode";
import NewPassword from "./components/RecoverPassword/NewPassword";
import MessagePasswordChanged from "./components/RecoverPassword/MessagePasswordChanged";
import TimeLine from "./components/TimeLine/TimeLine";
import ViewPost from "./components/TimeLine/viewPost";
import NewPost from "./components/TimeLine/newPost";
import Profile from "./components/Profile/Profile";
import EditProfile from "./components/Profile/EditProfile";
import ViewProfile from "./components/Profile/ViewProfile";
import Search from "./components/Search/Search";
import Inbox from "./components/Chat/Inbox";
import ChatMessages from "./components/Chat/ChatMessages";
import BlocksList from "./components/Block/BlocksList";

Vue.use(Router);

const router = new Router({
  mode: "history",
  base: process.env.BASE_URL,
  routes: [{
    path: "/",
    component: LoginDate,
    meta: { requiresLogin: false }
  }, {
    path: "/loginemail",
    name: "loginemail",
    component: LoginEmail,
    meta: { requiresLogin: false }
  }, {
    path: "/comments",
    name: "comments",
    component: Comments,
    meta: { requiresLogin: true }
  }, {
    path: "/offline",
    component: Offline,
    meta: { requiresLogin: false }
  }, {
    path: "/splash",
    component: Splash,
    meta: { requiresLogin: false }
  }, {
    path: "/login",
    component: Login,
    meta: { requiresLogin: false }
  }, {
    path: "/profile",
    component: Profile,
    meta: { requiresLogin: true }
  }, {
    path: "/register",
    component: Register,
    meta: { requiresLogin: false }
  }, {
    path: "/category",
    component: Category,
    name: "category",
    meta: { requiresLogin: false }
  }, {
    path: "/recover-password",
    component: RecoverPassword,
    meta: { requiresLogin: false }
  }, {
    path: "/thankyou",
    component: ThankYou,
    meta: { requiresLogin: false }
  }, {
    path: "/timeline",
    component: TimeLine,
    meta: { requiresLogin: true }
  }, {
    path: "/new-post",
    component: NewPost,
    meta: { requiresLogin: true }
  }, {
    path: "/edit-profile",
    component: EditProfile,
    meta: { requiresLogin: true }
  }, {
    path: "/view-post/:id",
    component: ViewPost,
    meta: { requiresLogin: true }
  }, {
    path: "/recover-code",
    component: RecoverCode,
    meta: { requiresLogin: false }
  }, {
    path: "/new-password",
    component: NewPassword,
    meta: { requiresLogin: false }
  }, {
    path: "/message-password",
    component: MessagePasswordChanged,
    meta: { requiresLogin: false }
  }, {
    path: "/view-profile/:id",
    component: ViewProfile,
    meta: { requiresLogin: true }
  }, {
    path: "/search",
    component: Search,
    meta: { requiresLogin: true }
  }, {
    path: "/inbox",
    component: Inbox,
    meta: { requiresLogin: true }
  }, {
    path: "/chat",
    component: ChatMessages,
    meta: { requiresLogin: true }
  }, {
    path: "/users-block",
    component: BlocksList,
    meta: { requiresLogin: true }
  }
  ],
  scrollBehavior() {
    window.scrollTo(0, 0);
  }
});

router.beforeEach((to, from, next) => {
  const json = localStorage.getItem(userKey);

  if (to.matched.some(record => record.meta.requiresLogin)) {
    const user = JSON.parse(json);
    user && user.token ? next() : next({ path: "/" });
  } else {
    next();
  }
});

export default router;