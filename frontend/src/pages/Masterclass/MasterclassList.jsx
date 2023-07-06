import AddMasterclass from "../../components/Masterclass/AddMasterclass";
import Get_MasterclassList from "../../components/Masterclass/MasterclassList";

const MasterclassList = () => {
    return (
        <div className="w-full px-4 lg:px-16 md:px-16">
            <Get_MasterclassList></Get_MasterclassList>
            <AddMasterclass></AddMasterclass>
        </div>
    );
};

export default MasterclassList;
