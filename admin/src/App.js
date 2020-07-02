import React from "react";
import BookIcon from "@material-ui/icons/Book";
import UserIcon from "@material-ui/icons/Group";
import MenuBookIcon from "@material-ui/icons/MenuBook";
import ViewQuiltIcon from "@material-ui/icons/ViewQuilt";
import { Admin, Resource, ListGuesser, EditGuesser } from "react-admin";
import hasuraDataProvider from "ra-data-hasura";
import { UserList, UserEdit } from "./components/users";

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
    <Resource name="users" list={UserList} edit={UserEdit} icon={UserIcon} />
    <Resource name="books" list={ListGuesser} icon={BookIcon} />
    <Resource name="pages" list={ListGuesser} icon={MenuBookIcon} />
    <Resource name="blocks" list={ListGuesser} icon={ViewQuiltIcon} />
  </Admin>
);

export default App;
