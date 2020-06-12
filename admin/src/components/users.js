import React from "react";
import {
  List,
  Datagrid,
  TextField,
  EmailField,
  BooleanField,
  NumberField,
  ImageField,
  EditButton,
} from "react-admin";

export const UserList = (props) => (
  <List {...props}>
    <Datagrid rowClick="edit">
      <TextField source="id" />
      <ImageField source="thumbnail" />
      <TextField source="name" />
      <TextField source="username" />
      <EmailField source="email" />
      <TextField source="status" />
      <BooleanField source="sticky" />
      <NumberField source="order" />
      <EditButton />
    </Datagrid>
  </List>
);
