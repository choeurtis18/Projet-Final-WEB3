import {configureStore} from "@reduxjs/toolkit";
import {RootReducer}  from "../Reducer/RootReducer"

export const Store = configureStore({reducer:  RootReducer});