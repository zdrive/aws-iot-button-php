--
-- Table structure for table `t_iotbuttontracker`
--

CREATE TABLE `t_iotbuttontracker` (
  `IO_ID` int(11) NOT NULL,
  `IO_clickType` varchar(6) NOT NULL,
  `IO_serialNumber` varchar(16) NOT NULL,
  `IO_batteryVoltage` varchar(6) NOT NULL,
  `IO_StartTime` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_iotsettings`
--

CREATE TABLE `t_iotsettings` (
  `IS_ID` int(11) NOT NULL,
  `IS_AWSbuttonSN` varchar(16) NOT NULL,
  `IS_ButtonTrackerID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_iotsettings`
--

INSERT INTO `t_iotsettings` (`IS_ID`, `IS_AWSbuttonSN`, `IS_ButtonTrackerID`) VALUES
(1, 'A123BC456789DEFG', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_iotbuttontracker`
--
ALTER TABLE `t_iotbuttontracker`
  ADD PRIMARY KEY (`IO_ID`);

--
-- Indexes for table `t_iotsettings`
--
ALTER TABLE `t_iotsettings`
  ADD PRIMARY KEY (`IS_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_iotbuttontracker`
--
ALTER TABLE `t_iotbuttontracker`
  MODIFY `IO_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `t_iotsettings`
--
ALTER TABLE `t_iotsettings`
  MODIFY `IS_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

