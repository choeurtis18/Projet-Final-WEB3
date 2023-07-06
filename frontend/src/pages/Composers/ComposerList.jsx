import AddComposer from "../../components/Composer/AddComposer";
import Get_ComposerList from "../../components/Composer/ComposerList";

const ComposerList = () => {
    return (
        <div className="w-full px-4 lg:px-16 md:px-16">
            <Get_ComposerList ></Get_ComposerList>
            <AddComposer></AddComposer>
        </div>
    );
};

export default ComposerList;
