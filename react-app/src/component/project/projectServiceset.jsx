import React, {Component} from 'react';
import StateBar from './stateBar.jsx'


class ProjectServiceset extends Component {

    render() {
        const stateInfo = {
            currState: this.props.serviceset.id_state,
            list: this.props.serviceset.list
        };

        console.log(stateInfo);

        <div className="servicelist-index col-md-12">
            <StateBar  />
        </div>
    }

}

export default ProjectServiceset;