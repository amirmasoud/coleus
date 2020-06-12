import React from "react";
import PostIcon from "@material-ui/icons/Book";
import UserIcon from "@material-ui/icons/Group";
import { Admin, Resource, ListGuesser, EditGuesser } from "react-admin";
import hasuraDataProvider from "ra-data-hasura";
import { UserList } from "./components/users";

// The following components are created when following the react-admin tutorial
// import { PostList, PostEdit, PostCreate, PostShow } from "./posts";
// import { UserList } from "./users";
// import Dashboard from "./Dashboard";
// import authProvider from "./authProvider";

const headers = {
  "content-type": "application/json",
  authorization: "bearer <token>",
};
const App = () => (
  <Admin
    dataProvider={hasuraDataProvider("http://graphql.coleus.test", headers)}
    // authProvider={authProvider}
    // dashboard={Dashboard}
  >
    {/* <Resource
      name="posts"
      icon={PostIcon}
      list={PostList}
      edit={PostEdit}
      create={PostCreate}
      show={PostShow}
    />
    <Resource name="users" icon={UserIcon} list={UserList} /> */}
    <Resource name="users" list={UserList} edit={EditGuesser} />
    <Resource name="books" list={ListGuesser} />
    <Resource name="pages" list={ListGuesser} />
    <Resource name="blocks" list={ListGuesser} />
  </Admin>
);

export default App;
