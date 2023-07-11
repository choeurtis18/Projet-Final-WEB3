import {useHistory, useLocation} from "react-router-dom";
import {useSelector} from "react-redux";

export default function ProtectedRoutes(props) {
    const location = useLocation();
    const history = useHistory();
    const storedUser = useSelector(store => store.LoginReducer);

    if (storedUser) {
        return props.children;
    } else {
        return history.push('/login')
    }
}