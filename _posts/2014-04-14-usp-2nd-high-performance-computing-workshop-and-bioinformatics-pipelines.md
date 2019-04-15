---
layout: single
title: "USP 2nd High Performance Computing Workshop and Bioinformatics pipelines"
description: "Attended this workshop to learn more about bioinformatics pipelines"
category: 
tags: ["news","pipelines"]
author: Bruno P. Kinoshita
---

<p>I have just returned from Universidade de Sao Paulo, where I attended the 
[2&ordm; High Performance Computing Workshop](http://2whpc.lcca.usp.br/). Unfortunately I couldn't go in the morning, so I 
missed the first half of the event. From what I read in the schedule, in the morning 
USP and Rice University explained what was the current situation of the cooperation 
agreement - that is mainly about Rice's IBM Bluegene/P being used by USP.</p>

My main reason to attend this event was to watch **Professor Dr. Jo&atilde;o Carlos 
Setubal's talk on HPC and Bioinformatics**. His talk was great, but I'll add a full 
report here, with all the talks that I watched (you can skip to his talk if you prefer).

## GPU computing talk

The first talk was by Phd. Denis Tanigushi. He gave a great talk about GPU computing. 
He started with a history background, that was coincidentally similar to a recent 
[Hacker News thread about shaders](http://notes.underscorediscovery.com/shaders-a-primer/).
He then exposed the problem, GPU architecture and its application in HPC. What was very 
interesting was that he used several GPUs and MPI too - I didn't know it was possible. 

<center><img width="500" src='{{ site.url }}/assets/posts/usp_2nd_hpc_workshop_01.jpg' alt="USP 2nd HPC Workshop" /></center>

I learned about [Warps](http://stackoverflow.com/questions/11816786/why-bother-to-know-about-cuda-warps), and when/how to use GPU. Here are some of 
the software that appeared in Tanigushi's talk: Matlab, NVidia libraries, Ansys and 
Gromacs. Oh, he also mentioned C thrust library and *functors*.

## The bioinformatics talk

The next part of the event was very interesting too. It was a series of 4 lighting talks, 
the first one being the HPC and bioinformatics that I wanted to see. [Prof. Setubal](http://www.iq.usp.br/setubal/) gave an 
excellent talk. He talked about his work with **Genomics and Transcriptomics**. He also 
mentioned that his work is of **collaboration** with other groups and **Project Driven**. Ah, and 
that it is also **Big Data Driven**.

<center><img width="500" src='{{ site.url }}/assets/posts/usp_2nd_hpc_workshop_02.jpg' alt="USP 2nd HPC Workshop" /></center>

He used Blast, MPI-Blast, SOAP Denovo and Abyss for his analysis. And found out that 
Abyss didn't work well in Bluegene, but on the other hand, using MPI-Blast he was able to 
reduce the processing time from 2 months to 3 days only the time to blast his dataset.

He concluded his talk saying that most of his tools are made by other groups, but not always 
made to run in parallel. And that it almost always **produces a pipeline** to run everything. 
From what I could understand asking him later, his group doesn't use any kind of pipeline 
tool - no Galaxy, Taverna, Mobyle, nor Jenkins (cough cough)

## The rest of the event

<!--more-->

The next speakers were two members of the IT school, presenting their work and team, 
that helps groups fine tuning their clusters. Unfortunately I couldn't ask them whether they 
share their data (like cluster monitoring results, and compiler flags).

The last lighting talk before coffee break was Prof. Dr. Att&iacute;lio Cucchieri. This talk was awesome 
too. It was about atoms, quarks, molecule. All those names that you hear in The
Big Bang Theory. Prof. Cucchieri really knows what he is talking about. His 
talk was interesting, with many examples and real cases of use of the Bluegene 
supercomputer. I felt like I could like learning more about what he was talking 
about.

<center><img width="500" src='{{ site.url }}/assets/posts/usp_2nd_hpc_workshop_03.jpg' alt="USP 2nd HPC Workshop" /></center>

(pause for coffee break)

Finally, after the coffee break we had four more lighting talks. The first one was by 
the young Dr. Ricardo O. S. Soares, about dengue, molecules, proteins and many 
amazing videos, animations and illustrations. Looks like he uses a lot of GPU 
for processing his data. 

The next two talks were probably my favorites after Prof. Setubal's. Prof. Juarez 
L. F. da Silva talked about nanoclusters and Prof. Ricardo de Camargo gave great 
examples of using HPC for weather forecasting processing using HPC. 

<center><img width="500" src='{{ site.url }}/assets/posts/usp_2nd_hpc_workshop_04.jpg' alt="USP 2nd HPC Workshop" /></center>

Last but not least, Prof. Dr. Leonardo Matheus Marion Jorge, presenting the works 
of his groups with molecules and, yup, more amazing illustrations. Not sure who 
was younger, Prof. Leonardo or Dr. Ricardo, but both were amazing.

## What I liked about the event

The event atmosphere was great. The auditorium too, as well as the quality of the talks 
and the coffee break (nham nham). I learned more about what USP has to offer to its 
students, researchers and collaborators, as well as a bit more about which bioinformatics 
tools they are using.

Ah! And the event was transmitted to the Internet too, and the organizers took  
care to not let people ask questions without using the mic.

## What I didn't like so much about the event

I really enjoyed the event! But one thing bugged me.

Most of the talks that I watched mentioned some Open Source software. The university has a 
[group dedicated to Open Source](http://ccsl.ime.usp.br/), but there was 
no word about sharing data from the HPC servers (monitoring, patches, or 
enhancements) back with these projects, sending contributions or even donations. Maybe there is 
some contribution happening, but I couldn't find anything about it.

I was expecting to leave the event with some GitHub repos to follow, but 
unfortunately the speakers didn't provided any link too.