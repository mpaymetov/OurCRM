import React, {Component} from 'react';
import UpdateButton from '../button/updateButton.jsx';
import DeleteButton from '../button/deleteButton.jsx';

class ProjectInfo extends Component {

    render() {
        return (
            <div className={"col-md-6 project-view"}>
                <h1>{this.props.projectInfo.name}</h1>
                <p>
                    <UpdateButton buttonInfo = {this.props.projectInfo.updateButton} />
                    <DeleteButton buttonInfo = {this.props.projectInfo.deleteButton} />
                </p>
                <div className={"panel-body"}>
                    <p>{this.props.projectInfo.client}</p>
                    <p>{this.props.projectInfo.creation_date}</p>
                    <p>{this.props.projectInfo.comment}</p>
                </div>
            </div>
        );
    }
    
}

export default ProjectInfo;