import React, {Component} from 'react';

class EventInfo extends Component{

    render() {
        return (
            <div className={"post panel"}>
                <div className={"panel-body"}>
                    <p>{this.props.eventInfo.text}</p>
                    <p>Дата создания {this.props.eventInfo.creation_date}</p>
                    <p>Дата выполнения {this.props.eventInfo.assignment_date}</p>
                </div>

            </div>
        );
    }

}

export default EventInfo;