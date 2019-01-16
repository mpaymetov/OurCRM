import React, {Component} from 'react';
import FirstColumn from './firstColumn.jsx';
import SecondColumn from './secondColumn.jsx';
import ThirdColumn from './thirdColumn.jsx';
import FourthColumn from './fourthСolumn.jsx';
import FifthColumn from './fifthColumn.jsx';

class StatusRow extends Component {
    constructor(props) {
        super(props);
        this.state = {data: this.props.data};
    }

    render() {
        return (
            <div>
                <div className={"col-md-2 status_column"}>
                    <div><p>Установление контакта</p></div>
                    <FirstColumn column={this.state.data[0]}/>
                </div>
                <div className={"col-md-2 status_column"}>
                    <div><p>Выявление потребностей</p></div>
                    <SecondColumn column={this.state.data[1]}/>
                </div>
                <div className={"col-md-2 status_column"}>
                    <div><p>Выставление счета</p></div>
                    <ThirdColumn column={this.state.data[2]}/>
                </div>
                <div className={"col-md-2 status_column"}>
                    <div><p>Оплата</p></div>
                    <FourthColumn column={this.state.data[3]}/>
                </div>
                <div className={"col-md-2 status_column"}>
                    <div><p>Поставка</p></div>
                    <FifthColumn column={this.state.data[4]}/>
                </div>

            </div>
        )
    }
}

export default StatusRow;
/**    **/