#!/usr/bin/python
from subprocess import Popen, PIPE
from Bio import Phylo

# Need to set matplotlib to use 'Agg' so that xwindows is not active and gel images can be generated.
import matplotlib
matplotlib.use('Agg')
import networkx, pylab
megacc = '/usr/bin/megacc';

output_dir = '/var/www/CpnClassiPhyRWebUI/CpnClassiPhyR/db'
fasta_infile = output_dir + '/' + 'subgroups_tree.fasta'
mega_align_options_infile = output_dir + '/' + 'clustalw_align.mao'
mega_align_filename = output_dir + '/' + 'subgroups_clustalw_align'

#megacc -d phylo_phyto_tree.fasta -a clustalw_align.mao -o megacc_test.txt
megacc_align_cmd = " ".join([megacc, "-d", fasta_infile, "-a", mega_align_options_infile, "-o", mega_align_filename])
print(megacc_align_cmd)
p1 = Popen(megacc_align_cmd, stdout=PIPE, stderr=PIPE, shell=True, executable='/bin/bash')
(megacc_align_results, err) = p1.communicate()
p1_status = p1.wait()

megacc_align_output = megacc_align_results.decode("utf-8")
print(megacc_align_output)
print(err.decode("utf-8"))
print(p1_status)

if(p1_status == 0):
    mega_align_infile = mega_align_filename + '.meg'
    print(mega_align_infile)

    #mega_tree_options_infile = '/home/muirheadk/tree_builder_specs.mao'
    #mega_tree_options_infile = '/home/muirheadk/neighbor-joining-tree-params.mao'
    #mega_tree_options_infile = '/home/muirheadk/MP-MEGA.mao'
    mega_tree_options_infile = output_dir + '/' + 'NJ_nucleotide.mao'
    mega_tree_filename = output_dir + '/' + 'subgroups_mega_tree'
    
    mega_best_tree_infile = mega_tree_filename + '.nwk'
    print(mega_best_tree_infile)
    
    mega_consensus_tree_infile = mega_tree_filename + '_' + 'consensus.nwk'
    print(mega_consensus_tree_infile)
    
    #megacc -d megacc_test.meg -a tree_builder_specs.mao  -o ML-Test-2018-07-14.txt
    megacc_tree_cmd = " ".join([megacc, "-d", mega_align_infile, "-a", mega_tree_options_infile, "-o", mega_tree_filename])
    print(megacc_tree_cmd)
    p2 = Popen(megacc_tree_cmd, stdout=PIPE, stderr=PIPE, shell=True, executable='/bin/bash')
    (megacc_tree_results, err) = p2.communicate()
    p2_status = p2.wait()

    megacc_tree_output = megacc_tree_results.decode("utf-8")
    print(megacc_tree_output)
    print(err.decode("utf-8"))
    print(p2_status)

    if(p2_status == 0):


        best_tree = Phylo.read(mega_best_tree_infile, 'newick')
        print(best_tree)
        
        best_tree.root_with_outgroup({'name': 'b30065_LXYB01000004_Acholeplasma_laidlawii_PG8R10'})
        best_tree.rooted = True
        
        Phylo.draw(best_tree)
        pylab.savefig(mega_tree_filename + '.png')
        
        Phylo.write(best_tree, mega_tree_filename + '.nwk', 'newick')
        Phylo.write(best_tree, mega_tree_filename + '.xml', 'phyloxml')
        
        consensus_tree = Phylo.read(mega_consensus_tree_infile, 'newick')
        print(consensus_tree)
        
        consensus_tree.root_with_outgroup({'name': 'b30065_LXYB01000004_Acholeplasma_laidlawii_PG8R10'})
        consensus_tree.rooted = True

        Phylo.draw(consensus_tree)
        pylab.savefig(mega_tree_filename + '_' + 'consensus.png')
        
        Phylo.write(consensus_tree, mega_tree_filename + '_' + 'consensus.nwk', 'newick')
        Phylo.write(consensus_tree, mega_tree_filename  + '_' + 'consensus.xml', 'phyloxml')
