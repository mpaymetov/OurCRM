import React, {Component} from 'react';


class StateItem extends Component {

    constructor(props) {
        super(props);
        this.state = {
            classDiv: "",
        };

        this.initClass = this.initClass.bind(this);
    }

    initClass() {
        let classNameDiv = "btn status-item status-" + this.props.item.listElem.id;
        if(this.props.item.listElem.id > this.props.item.curr) {
            classNameDiv += " btn-warning";
        } else {
            classNameDiv += " btn-success";
        }
        this.setState({classDiv: classNameDiv});
    }

    componentWillMount(){
        this.initClass();
    }


    render() {

        if(this.props.item !== '') {

            let classNameDiv = this.state.classDiv + this.props.item.listElem.id;
            //classNameDiv += (this.props.item.listElem.id > this.props.item.curr) ? "btn-warning" : "btn-success";
            if(this.props.item.listElem.id > this.props.item.curr) {
                classNameDiv += " btn-warning";
            } else {
                classNameDiv += " btn-success";
            }


            return (
                <a className={this.state.classDiv}>
                    {this.props.item.listElem.name}
                </a>
            );
        } else {
            return (
                <div></div>
            );
        }

    }

}

export default StateItem;
