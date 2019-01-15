import React, {Component} from 'react';
import StateBar from './stateBar.jsx';
import ServicesetInfo from './servicesetInfo.jsx';
import ServiceList from "./serviceList.jsx";
import UpdateButton from '../button/updateButton.jsx';
import DeleteButton from '../button/deleteButton.jsx';
import CloseButton from  '../button/closeButton.jsx';
import CancellationButton from  '../button/cancellationButton.jsx'


class ProjectServiceset extends Component {

    render() {

        if(this.props.serviceset !== '') {

           const stateInfo = {
                currState: this.props.serviceset.servicesetInfo.id_state,
                stateList: this.props.serviceset.list,
                prevState: this.props.serviceset.servicesetInfo.prev_state,
                idServiceset: this.props.serviceset.servicesetInfo.id,
                setIsOpen: this.props.serviceset.servicesetInfo.is_open
            };

            return (
                <div className={"serviceset-info-" + this.props.serviceset.servicesetInfo.id}>
                    <h2>Пакет услуг от {this.props.serviceset.servicesetInfo.creation_date}</h2>
                    <p>
                        <UpdateButton buttonInfo = {{buttonName: "Изменить пакет услуг", path: "#"}} />
                        <DeleteButton buttonInfo = {{buttonName: "Удалить пакет услуг", path: "#"}} />
                    </p>
                    <p>
                        <CloseButton buttonInfo = {{buttonName: "Закрыть", path: "#"}}/>
                        <CancellationButton buttonInfo = {{buttonName: "Отказ", path: "#"}}/>
                    </p>
                    <StateBar set={stateInfo}/>
                    <ServicesetInfo info = {this.props.serviceset.servicesetInfo}/>
                    <ServiceList list = {this.props.serviceset.servicelistInfo} />
                </div>
            );
        } else {
            return (
                <div></div>
            );
        }

    }

}

export default ProjectServiceset;