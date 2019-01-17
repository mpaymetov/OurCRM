import React, {Component} from 'react';
import UpdateButton from '../button/updateButton.jsx';
import DeleteButton from '../button/deleteButton.jsx';

class ProjectInfo extends Component {

    render() {

        return (
            <div className={"col-md-6 project-view panel-body panel shadow"}>
                <p>
                    <UpdateButton buttonInfo = {{buttonName: "Изменить проект", path: "#"}} />
                    <DeleteButton buttonInfo = {{buttonName: "Удалить проект", path: "#"}} />
                </p>
                <h1>{this.props.projectInfo.name}</h1>
                <div className={""}>
                    <p>{this.props.projectInfo.id_client}</p>
                    <p>{this.props.projectInfo.creation_date}</p>
                    <p>{this.props.projectInfo.comment}</p>
                </div>

            </div>
        );
    }
    
}

export default ProjectInfo;